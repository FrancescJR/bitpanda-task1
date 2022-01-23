<?php

declare(strict_types=1);

namespace Bitpanda\User\Application;

use Bitpanda\User\Domain\UserIsNotEditableException;
use Bitpanda\User\Domain\UserNotFoundException;
use Bitpanda\User\Domain\UserRepositoryInterface;

final class EditUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param EditUserCommand $editUserCommand
     * @return void
     * @throws UserNotFoundException
     * @throws UserIsNotEditableException
     */
    public function __invoke(EditUserCommand $editUserCommand): void
    {
        $user = $this->userRepository->find($editUserCommand->userId);

        if ($editUserCommand->phoneNumber) {
            $user->setPhoneNumber($editUserCommand->phoneNumber);
        }

        $this->userRepository->save($user);

    }

}
