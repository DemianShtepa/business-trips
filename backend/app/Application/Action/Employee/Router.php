<?php

declare(strict_types=1);

namespace App\Application\Action\Employee;

use App\Application\Action\Employee;
use Illuminate\Contracts\Routing\Registrar;

final class Router
{
    private Registrar $registrar;

    public function __construct(Registrar $registrar)
    {
        $this->registrar = $registrar;
    }

    public function register(): void
    {
        $this->registrar->group(['prefix' => '/employee'], function (): void {
            $this->registrar->post('/create', [Employee\Create\Action::class, '__invoke']);
        });
    }
}
