<?php

namespace App\services;


class SumService
{
    const MIN_SUMM = 0.5; //МИнимальная сумма

    /**
     * ПРеодразует строку в число
     *
     * @param $summ
     * @return float
     */
    public function getFloat($summ)
    {
        return (float)strtr($summ, ',', '.');
    }

    /**
     * Возвращает разность 2х чисел
     *
     * @param $firstNumber
     * @param $secondNumber
     * @return float
     */
    public function getDifferenceOfNumbers($firstNumber, $secondNumber)
    {
        return round(
            $this->getFloat($firstNumber) - $this->getFloat($secondNumber),
            2
        );
    }

    /**
     * Проверка минимальной суммы
     *
     * @param $summ
     * @return bool
     */
    public function hasMinSum($summ)
    {
        return self::MIN_SUMM <= $this->getFloat($summ);
    }
}
