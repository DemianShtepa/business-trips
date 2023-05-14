<?php

declare(strict_types=1);

namespace App\Application\Action\Trip\Create;

use App\Domain\Employee\Entity\Employee;
use App\Domain\Trip\Enum\Country;
use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\In;

final class Request extends FormRequest
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';
    public function rules(): array
    {
        $employeeExistsRule = new Exists(Employee::class, 'id');
        $countryInRule = new In([Country::PL->value, Country::DE->value, Country::GB->value]);

        return [
            'start' => ['required', 'date', 'date_format:' . self::DATETIME_FORMAT],
            'end' => ['required', 'date', 'date_format:' . self::DATETIME_FORMAT, 'after:start'],
            'employee_id' => ['required', 'integer', $employeeExistsRule],
            'country' => ['required', 'string', $countryInRule]
        ];
    }

    public function getStart(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $this->get('start'));
    }

    public function getEnd(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $this->get('end'));
    }

    public function getEmployeeId(): int
    {
        return (int)$this->get('employee_id');
    }

    public function getCountry(): Country
    {
        return Country::from((string)$this->get('country'));
    }
}
