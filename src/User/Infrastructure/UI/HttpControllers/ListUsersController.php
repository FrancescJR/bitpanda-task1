<?php

declare(strict_types=1);

namespace Bitpanda\User\Infrastructure\UI\HttpControllers;

use Bitpanda\User\Application\ListUsersCommand;
use Bitpanda\User\Application\ListUsersCommandHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListUsersController
{
    public function __construct(private ListUsersCommandHandler $commandHandler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $usersResponse = ($this->commandHandler)
        (
            new ListUsersCommand(
                $request->get('country')
            )
        );

        return new JsonResponse($usersResponse, Response::HTTP_OK);
    }

}
