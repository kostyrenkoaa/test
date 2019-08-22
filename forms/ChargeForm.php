<?php
namespace App\forms;

use App\models\Charge;
use App\services\Request;

/**
 * Class ChargeForm
 * @package App\forms
 */
class ChargeForm
{
    private $isValid = true;
    private $data;
    private $error;

    /**
     * ChargeForm constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        if ($request->getRequestMethod() != "POST") {
            $this->isValid = false;
            $this->error = 'Данные должны быть переданы методом post';
            return;
        }

        $params = $request->getParams('post', 'charge');

        if (!is_array($params) || empty($params['account']) || empty($params['summ']) || empty($params['currency'])) {
            $this->isValid = false;
            $this->error = 'Не все данные переданы';
            return;
        }

        $this->data = new Charge();
        $this->data->setAccount($params['account']);
        $this->data->setSumm($params['summ']);
        $this->data->setCurrency($params['currency']);

    }

    /**
     * Проверка валидности формы
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * Возвращает переданные данные ввиде модели
     *
     * @return Charge
     */
    public function getData(): Charge
    {
        return $this->data;
    }
}
