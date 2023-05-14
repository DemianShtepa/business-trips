<?php

declare(strict_types=1);

namespace App\Domain\Trip\Service;

use App\Domain\Trip\Enum\Country;
use App\Domain\Trip\Enum\Currency;
use App\Domain\Trip\Exception\PerDiemCalculationException;
use App\Domain\Trip\ValueObject\PerDiem;
use Carbon\CarbonImmutable;
use DateTimeImmutable;

final class PerDiemFactory
{
    private function countryPerDiemAmounts(): array
    {
        return [
            Country::PL->value => [
                Currency::PLN->value => 10,
            ],
            Country::DE->value => [
                Currency::PLN->value => 50,
            ],
            Country::GB->value => [
                Currency::PLN->value => 75,
            ],
        ];
    }

    public function create(
        Country $country,
        Currency $currency,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
    ): PerDiem {
        $countryPerDiemAmounts = $this->countryPerDiemAmounts();
        if (!array_key_exists($country->value, $countryPerDiemAmounts)) {
            throw new PerDiemCalculationException('Per diem for this country doesn\'t exist');
        }
        $countryPerDiemAmount = $countryPerDiemAmounts[$country->value];

        if (!array_key_exists($currency->value, $countryPerDiemAmount)) {
            throw new PerDiemCalculationException('Per diem for this currency doesn\'t exist');
        }

        $amount = 0;
        $perDiemForDay = $countryPerDiemAmount[$currency->value];

        $start = CarbonImmutable::instance($start);
        $end = CarbonImmutable::instance($end);
        $difference = $end->diffAsCarbonInterval($start);
        if ($difference->totalHours < 8) {
            return new PerDiem($currency, 0);
        }
        $difference = $difference->ceilDays();

        for ($i = 0; $i < $difference->totalDays; $i++) {
            $currentDay = $start->addDays($i);
            if ($currentDay->isWeekend()) {
                continue;
            }

            $startOfDay = $currentDay->startOfDay();
            $endOfDay = $currentDay->endOfDay();

            if ($startOfDay < $start) {
                $startOfDay = $start;
            }

            if ($endOfDay > $end) {
                $endOfDay = $end;
            }

            $hoursPerDay = $startOfDay->diffAsCarbonInterval($endOfDay);
            if ($hoursPerDay->totalHours > 8) {
                if ($i > 6) {
                    $amount += $perDiemForDay * 2;
                } else {
                    $amount += $perDiemForDay;
                }
            }
        }

        return new PerDiem($currency, $amount);
    }
}
