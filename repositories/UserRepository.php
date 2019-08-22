<?php
namespace App\repositories;

use App\main\App;
use App\entities\User;

/**
 * Class UserRepository
 * @package App\repositories
 *
 * @method User getOne($id)
 */
class UserRepository extends Repository
{
    public function getTableName(): string
    {
        return 'users';
    }

    protected function getEntityClass()
    {
        return User::class;
    }

    /**
     * Получение пользователя по его логину
     *
     * @param $login
     * @return User|null
     */
    public function getUserByLogin($login)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE login = :login";
        return $this->db->getObject($sql, $this->getEntityClass(), [':login' => $login]);
    }

    /**
     * Получение пользователя по его токину
     *
     * @param $token
     * @return User|null
     */
    public function getUserByToken($token)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE token = :token";
        return $this->db->getObject($sql, $this->getEntityClass(), [':token' => $token]);
    }
}
