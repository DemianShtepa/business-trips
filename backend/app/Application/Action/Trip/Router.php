<?php

declare(strict_types=1);

namespace App\Application\Action\Trip;

use App\Application\Action\Trip;
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
        $this->registrar->group(['prefix' => '/trip'], function (): void {
            $this->registrar->get('/all', [Trip\All\Action::class, '__invoke']);
            $this->registrar->post('/create', [Trip\Create\Action::class, '__invoke']);
        });
    }
}
