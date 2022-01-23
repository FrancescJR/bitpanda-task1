<?php

declare(strict_types=1);

namespace Bitpanda\User\Infrastructure\UI\HttpControllers;

use Bitpanda\User\Application\DeleteUserCommand;
use Bitpanda\User\Application\DeleteUserCommandHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteUserController
{
    public function __construct(private DeleteUserCommandHandler $commandHandler)
    {
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        try {
            ($this->commandHandler)
            (
                new DeleteUserCommand(
                    $id
                )
            );
        } catch (\Exception  $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }


        return new JsonResponse([], Response::HTTP_OK);
    }

}
