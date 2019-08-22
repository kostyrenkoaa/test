<?php
namespace App\services;

use App\entities\Entity;

/**
 * Class Db
 * @package App\services
 * @method static self getInstance
 */
class Db
{
    /**
     * @var \PDO
     */
    protected $connection = null;

    private $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Возвращает всегда одно соединение с базой
     *
     * @return \PDO
     */
    private function getConnection()
    {
        if (empty($this->connection)) {
            $this->connection = new \PDO(
                $this->getDsn(),
                $this->config['user'],
                $this->config['password']
            );
            $this->connection->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
            );
        }
        return $this->connection;
    }

    /**
     * Создает dsn строку для создания подключения
     *
     * @return string
     */
    private function getDsn()
    {
        //mysql:host=localhost;dbname=DB;charset=UTF8
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $this->config['driver'],
            $this->config['host'],
            $this->config['db'],
            $this->config['charset']
        );
    }

    /**
     * Выполнение запроса к базе данных
     *
     * @param string $sql Пример SELECT * FROM users WHERE id = :id
     * @param array $params Пример [':id' => 2]
     * @return bool|\PDOStatement
     */
    private function query(string $sql, array $params = [])
    {
        $PDOStatement = $this->getConnection()->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /**
     * Возвращает сущность по указанному запросу
     *
     * @param $sql
     * @param $class
     * @param array $params
     * @return null|Entity
     */
    public function getObject($sql, $class, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $PDOStatement->fetch();
    }

    /**
     * Возвращает набор сущностей по указанному запросу
     *
     * @param $sql
     * @param $class
     * @param array $params
     * @return array
     */
    public function getObjects($sql, $class, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $PDOStatement->fetchAll();
    }

    /**
     * Поиск одной записи
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function find(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Поиск всех записей
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function findAll(string $sql, array $params = []):array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function execute(string $sql, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        /**@var \PDOStatement $PDOStatement */
        return (! is_bool($PDOStatement)) ? $PDOStatement->rowCount() : 0 ;
    }

    /**
     * Возвращает последний добавленыый id
     *
     * @return string
     */
    public function getLastId()
    {
        return $this->getConnection()->lastInsertId();
    }

    /**
     * Выполнение транзакций
     *
     * @param $queries
     */
    public function executeTransaction($queries)
    {
        $connection = $this->getConnection();
        try {
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $connection->beginTransaction();

            foreach ($queries as $query) {
                $this->query($query['sql'], $query['params']);
            }

            $connection->commit();

        } catch (\Exception $e) {
            $connection->rollBack();
            echo "Ошибка: " . $e->getMessage();
        }
    }
}