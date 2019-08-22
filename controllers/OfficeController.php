<?php
namespace App\controllers;

use App\forms\ChargeForm;
use App\main\App;

class OfficeController extends Controller
{
    /**
     * Вывод страницы с формой списания средств
     *
     * @throws
     */
    public function indexAction()
    {
        $token = $this->request->getSession('token');
        $accounts = $this->app->bankAccountRepository->getAccountsByToken($token);
        $currencies = $this->app->currencyServices->getCurrencies();
        if (empty($currencies)) {
            echo $this->render('office', ['error' => 'Операции не возможны']);
            return;
        }

        $params = [
            'accounts' => $accounts,
            'currencies' => $currencies,
        ];

        echo $this->render('office', $params);
    }

    /**
     * Списание средств
     *
     * @throws
     */
    public function chargeAction()
    {
        $form = new ChargeForm($this->request);
        if (!$form->isValid()) {
            return $this->redirect();
        }
        $charge = $form->getData();

        $userId = $this->request->getSession('userId');
        $this->request->sessionWriteClose();

        $chargeService = $this->app->chargeService;
        $bankAccount = $chargeService->getBlockedAccount($charge, $userId);
        if (empty($bankAccount)) {
            return $this->redirect();
        }

        $currencyServices = $this->app->currencyServices;

        $newSumm = $currencyServices->getNewSumm($charge, $bankAccount);

        $bankAccountRepository = $this->app->bankAccountRepository;
        if (is_null($newSumm) || $newSumm < 0) {
            $bankAccountRepository->unBlock($charge->getAccount());
            return $this->redirect();
        }

        $newSummInCurrencyAccount = $currencyServices->convertFromRub($newSumm, $bankAccount->currency);
        $bankAccountRepository->updateSummAndUnsetBlock(
            $charge,
            $charge->getAccount(),
            $newSummInCurrencyAccount,
            $userId
        );

        return $this->redirect();
    }

    /**
     * Вывод отчета по списанию средств
     */
    public function reportAction()
    {
        $token = $this->request->getSession('token');
        $logs = $this->app->operationLogRepository->getLogsByToken($token);

        echo $this->render('report', ['logs' => $logs]);
    }

    /**
     * Вывод отчета по списанию средств
     *
     * @throws
     */
    public function currenciesAction()
    {
        $currencies = $this->app->currencyServices->getCurrencies();
        if (empty($currencies)) {
            echo $this->render('currencies', ['error' => 'Операции не возможны']);
            return;
        }

        $params = [
            'currencies' => $currencies,
        ];

        echo $this->render('currencies', $params);
    }
}
