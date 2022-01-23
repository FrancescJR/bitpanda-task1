<?php

declare(strict_types=1);

namespace Bitpanda\User\Infrastructure\UI\HttpControllers;

use Bitpanda\User\Application\EditUserCommand;
use Bitpanda\User\Application\EditUserCommandHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpdateUserController
{
    public function __construct(private EditUserCommandHandler $commandHandler)
    {
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            ($this->commandHandler)
            (
                new EditUserCommand(
                    $id,
                    $requestContent['phone_number']
                )
            );
        } catch (\Exception  $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }


        return new JsonResponse([], Response::HTTP_OK);
    }

}
