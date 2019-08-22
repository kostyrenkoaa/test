<?php
namespace App\models;

class Charge
{
    /**
     * @var string Аккаунт
     */
    private $account;

    /**
     * @var string Сумма
     */
    private $summ;

    /**
     * @var string Валюта
     */
    private $currency;

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account): void
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getSumm()
    {
        return $this->summ;
    }

    /**
     * @param mixed $summ
     */
    public function setSumm($summ): void
    {
        $this->summ = $summ;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }
}
