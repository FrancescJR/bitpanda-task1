<?php

declare(strict_types=1);

namespace Bitpanda\User\Application;

final class DeleteUserCommand
{
    public function __construct(public readonly int $userId)
    {

    }

}
