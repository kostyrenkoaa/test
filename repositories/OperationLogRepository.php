<?php
namespace App\repositories;

use App\main\App;
use App\entities\OperationLog;

/**
 * Class OperationLogRepository
 * @package App\repositories
 */
class OperationLogRepository extends Repository
{
    public function getTableName(): string
    {
        return 'opiration_logs';
    }

    protected function getEntityClass()
    {
        return OperationLog::class;
    }

    /**
     * Получение логов операций по авторизационному токену
     *
     * @param $token
     * @return array
     */
    public function getLogsByToken($token)
    {
        $sql = "SELECT ol.date, ol.summ, ol.currency, u.login FROM users u 
                LEFT JOIN opiration_logs ol ON ol.user_id = u.id WHERE u.token = :token";
        return $this->db->getObjects($sql, $this->getEntityClass(),  [':token' => $token]);
    }
}
