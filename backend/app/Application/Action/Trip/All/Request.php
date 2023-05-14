<?php

declare(strict_types=1);

namespace App\Application\Action\Trip\All;

use App\Domain\Employee\Entity\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

final class Request extends FormRequest
{
    public function rules(): array
    {
        $employeeExistsRule = new Exists(Employee::class, 'id');

        return [
            'employee_id' => ['required', 'int', $employeeExistsRule]
        ];
    }

    public function getEmployeeId(): int
    {
        return (int)$this->get('employee_id');
    }
}
