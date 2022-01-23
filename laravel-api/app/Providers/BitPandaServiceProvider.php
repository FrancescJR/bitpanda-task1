<?php

declare(strict_types=1);

namespace App\Providers;

use Bitpanda\User\Infrastructure\Persistence\Eloquent\UserRepository as EloquentUserRepository;
use Bitpanda\User\Domain\UserRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class BitPandaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->dependencyInjection();
    }

    private function dependencyInjection(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );
    }

}
