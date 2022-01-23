<?php

declare(strict_types=1);

namespace Bitpanda\User\Application;

use Bitpanda\User\Domain\UserNotDeletableException;
use Bitpanda\User\Domain\UserNotFoundException;
use Bitpanda\User\Domain\UserRepositoryInterface;

final class DeleteUserCommandHandler
{

    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param DeleteUserCommand $command
     * @return void
     * @throws UserNotDeletableException
     * @throws UserNotFoundException
     */
    public function __invoke(DeleteUserCommand $command): void
    {
        $user = $this->userRepository->find($command->userId);

        $user->delete();

        $this->userRepository->save($user);
    }

}
