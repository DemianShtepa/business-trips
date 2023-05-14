<?php

declare(strict_types=1);

namespace App\Domain\Trip\ValueObject;

use App\Domain\Trip\Enum\Currency;

final class PerDiem
{
    private Currency $currency;
    private float $amount;

    public function __construct(Currency $currency, float $amount)
    {
        $this->currency = $currency;
        $this->amount = $amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
