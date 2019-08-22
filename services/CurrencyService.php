<?php
namespace App\services;

use App\main\App;
use App\models\Charge;
use App\entities\BankAccount;
use App\entities\Currency;

/**
 * Class CurrencyService
 * @package App\services
 */
class CurrencyService
{
    const DEFAULT_CURRENCY = [
        'NumCode' => 643,
        'CharCode' => 'RUB',
        'Nominal' => 1,
        'Name' => 'Российский рубль ',
        'Value' => 1,
    ];

    /** @var array Массив курсов валют*/
    private $currencies = [];

    private $app;

    public function __construct()
    {
        $this->app = App::call();
    }

    /**
     * @return Currency
     */
    protected function updateCurrencies()
    {
        //Можно и curl но так быстрее..
        $currencyString = file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp');

        $xml = new \SimpleXMLElement($currencyString);

        $currenciesArray[self::DEFAULT_CURRENCY['CharCode']] = self::DEFAULT_CURRENCY;
        foreach ($xml as $currencies) {
            $charCode = (string)$currencies->CharCode;
            $currenciesArray[$charCode] = [
                'NumCode' => (string)$currencies->NumCode,
                'CharCode' => (string)$currencies->CharCode,
                'Nominal' => (string)$currencies->Nominal,
                'Name' => (string)$currencies->Name,
                'Value' => (string)$currencies->Value,
            ];
        }

        $currency = new Currency();
        $currency->id = 1;
        $currency->currency = json_encode($currenciesArray, JSON_UNESCAPED_UNICODE);
        $currency->date = date('Y-m-d H-i');

        $this->app->currencyRepository->save($currency);

        return $currenciesArray;
    }

    /**
     * Возвращает массив курсов
     *
     * @return Currency|mixed|null
     * @throws \Exception
     */
    public function getCurrencies()
    {
        if (!empty($this->currencies)) {
            return $this->currencies;
        }

        $currencies = $this->app->currencyRepository->getCurrencyInfo();
        $date = new \DateTime($currencies->date);

        //Обновление в 15:00
        if (date('H') > 15) {
            $dateDateUpdate = new \DateTime(date('Y-m-d ') . "15:00");
        } else {
            $dateDateUpdate = (new \DateTime())->modify('-1 day')->setTime(15,0);
        }

        if ($date->diff($dateDateUpdate)->d > 0) {
            try{
                $this->currencies = $this->updateCurrencies();
                return $this->currencies;
            } catch (\Exception $exception) {
                //Лог ошибки
                return null;
            }
        }

        $this->currencies = json_decode($this->app->currencyRepository->getCurrencyInfo()->currency, true);
        return $this->currencies;
    }

    /**
     * Конвертация в рубли
     *
     * @param $sum
     * @param $currency
     * @return float|int|null
     * @throws
     */
    public function convertInRub($sum, $currency)
    {
        $currencies = $this->getCurrencies();
        if (! isset($currencies[$currency])) {
            return null;
        }
        $nominal = (int)$currencies[$currency]['Nominal'];
        $value = (int)$currencies[$currency]['Value'];
        return ($value / $nominal) * $sum;
    }

    /**
     * Конвертация из рублей в указанную валюту
     *
     * @param $sum
     * @param $currency
     * @return float|null
     * @throws \Exception
     */
    public function convertFromRub($sum, $currency)
    {
        $currencies = $this->getCurrencies();
        if (! isset($currencies[$currency])) {
            return null;
        }
        $nominal = $currencies[$currency]['Nominal'];
        $value = $currencies[$currency]['Value'];
        return round($sum / ($value / $nominal), 2);
    }

    /**
     * Расчитывает остаток на счете с учетом валюты аккаунта и запрошенной валюты
     *
     * @param Charge $charge
     * @param BankAccount $bankAccount
     * @return float|null
     * @throws
     */
    public function getNewSumm(Charge $charge, BankAccount $bankAccount)
    {
        $currencies = $this->getCurrencies();
        if (!$currencies[$charge->getCurrency()]) {
            return null;
        }

        $sumService = $this->app->sumService;
        $summ = $this->convertInRub($sumService->getFloat($charge->getSumm()), $charge->getCurrency());

        if (!$sumService->hasMinSum($summ)) {
            return null;
        }

        $bankAccountSumm = $this->convertInRub($sumService->getFloat($bankAccount->summ), $bankAccount->currency);

        if (empty($bankAccountSumm)) {
            return null;
        }

        return $sumService->getDifferenceOfNumbers($bankAccountSumm, $summ);
    }
}
