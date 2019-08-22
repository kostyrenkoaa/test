<?php
namespace App\services;

use App\main\App;
use App\models\Charge;

class ChargeService
{
    private $app;

    public function __construct()
    {
        $this->app = App::call();
    }

    /**
     * Блокирует аккаунт и возвращает данные аккаунта при успешной блокировки
     *
     * @param Charge $charge
     * @param $userId
     * @return \App\entities\BankAccount|null
     * @throws \Exception
     */
    public function getBlockedAccount(Charge $charge, $userId)
    {
        $bankAccountRepository = $this->app->bankAccountRepository;
        $blockToken = uniqid('mc');
        $countRowUpdate = $bankAccountRepository->setBlockToken($blockToken, $charge->getAccount(), $userId);
        if ($countRowUpdate == 0) {
            return null;
        }

        return $bankAccountRepository->getAccountByTokenAndId($blockToken, $charge->getAccount());
    }
}
