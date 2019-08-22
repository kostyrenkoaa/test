<?php
namespace App\repositories;

use App\entities\Currency;

/**
 * Class CurrencyRepository
 * @package App\repositories
 */
class CurrencyRepository extends Repository
{
    public function getTableName(): string
    {
        return 'currency';
    }

    protected function getEntityClass()
    {
        return Currency::class;
    }

    /**
     * @return \App\entities\Entity|null|Currency
     */
    public function getCurrencyInfo()
    {
        return $this->getOne(1);
    }
}
