<?php
namespace App\repositories;

use App\main\App;
use App\models\Charge;
use App\entities\BankAccount;

/**
 * Class BankAccountRepository
 * @package App\repositories
 */
class BankAccountRepository extends Repository
{
    public function getTableName(): string
    {
        return 'bank_accounts';
    }

    protected function getEntityClass()
    {
        return BankAccount::class;
    }

    /**
     * Выбор банковских аккаунтов пользователя.
     * ! Не использовать для дальнейшего изменения данных в аккаунте. !
     *
     * @param $token
     * @return array
     */
    public function getAccountsByToken($token)
    {
        $sql = "SELECT ba.id, ba.summ, ba.currency, u.login 
                FROM users u 
                LEFT JOIN bank_accounts ba ON ba.user_id = u.id 
                WHERE u.token = :token";
        return $this->db->getObjects($sql, $this->getEntityClass(),  [':token' => $token]);
    }

    /**
     * Используется для получения банковского аккаунта по блокирующему токину и id аккаунта
     *
     * @param $blockToken
     * @param $idAccount
     * @return BankAccount
     */
    public function getAccountByTokenAndId($blockToken, $idAccount)
    {
        $sql = "SELECT summ, currency, token_block, date_block FROM bank_accounts 
                  WHERE token_block = :blockToken AND id = :id";
        return $this->db->getObject(
            $sql,
            $this->getEntityClass(),
            [':blockToken' => $blockToken, ':id' => $idAccount]
        );
    }

    /**
     * Выполняет изменение суммы в аккаунте. Логирование операции и разблокировка записи
     *
     * @param $idAccount
     * @param $summ
     * @param $newSumm
     * @param $userId
     */
    public function updateSummAndUnsetBlock(Charge $charge, $idAccount, $newSumm, $userId)
    {
        $queries = [
            [
                'sql' => "UPDATE {$this->getTableName()} SET summ = :summ, token_block = ''  WHERE id = :id ",
                'params' => [':id' => $idAccount, ':summ' => $newSumm]
            ],
            [
                'sql' => "INSERT INTO opiration_logs (user_id, summ, currency) VALUES (:user_id, :summ, :currency); ",
                'params' => [
                    ':user_id' => $userId,
                    ':summ' => $charge->getSumm(),
                    ':currency' => $charge->getCurrency(),
                    ]
            ],
        ];

        $this->db->executeTransaction($queries);
    }

    /**
     * Блокировка записи аккаунта.
     * Блокировка происходит в том случае, если запись еще не заблокирована
     * или прошла уже минута после последней блокировки.
     * Последние условие для того, чтоб при ошибках можно было работать дальше
     *
     * @param $blockToken
     * @param $idAccount
     * @param $userId
     * @return int
     * @throws \Exception
     */
    public function setBlockToken($blockToken, $idAccount, $userId)
    {
        $dateN = date('Y-m-d H:i:s');
        $dateBlock = (new \DateTime())->modify("-1 minutes")->format('Y-m-d H:i:s');
        $sql = "UPDATE {$this->getTableName()} SET 
                      token_block = :token, 
                      date_block = :dateN 
                      WHERE id = :idAccount AND  user_id = :userId and (token_block = '' OR date_block < :dateBlock ) ";

        return $this->db->execute(
            $sql,
            [
                ':token' => $blockToken,
                ':userId' => $userId,
                ':idAccount' => $idAccount,
                ':dateBlock' => $dateBlock,
                ':dateN' => $dateN,
            ]
        );
    }

    /**
     * Разблокировка аккаунта
     *
     * @param $idAccount
     */
    public function unBlock($idAccount)
    {
        $sql = "UPDATE {$this->getTableName()} SET token_block = ''  WHERE id = :id ";
        $this->db->execute($sql, [':id' => $idAccount]);
    }
}
