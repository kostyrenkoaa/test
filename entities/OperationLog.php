<?php
namespace App\entities;

/**
 * Class OperationLog
 * @package App\entities
 */
class OperationLog extends Entity
{
    /**@var string Дата операции*/
    public $date;

    /**@var int */
    public $user_id;

    /**@var string Сумма операции*/
    public $summ;

    /**@var string Код валюты*/
    public $currency;
}
