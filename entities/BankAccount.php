<?php
namespace App\entities;

/**
 * Class BankAccount
 * @package App\entities
 */
class BankAccount extends Entity
{
    /** @var int  */
    public $id;

    /** @var string Остаток на счете*/
    public $summ;

    /** @var string*/
    public $login;

    /** @var string Токен для блокировки*/
    public $token_block;

    /** @var string Дата установки токина*/
    public $date_block;

    /** @var string Валюта*/
    public $currency;
}
