<?php
namespace App\entities;

/**
 * Class Currency
 * @package App\entities
 */
class Currency extends Entity
{
    /** @var int  */
    public $id;

    /** @var string Дата обновления*/
    public $date;

    /** @var string Валюты*/
    public $currency;
}
