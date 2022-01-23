<?php

declare(strict_types=1);

namespace Bitpanda\User\Domain;


class User
{
    public function __construct(
        private int $id,
        private bool $isActive,
        private string $email,
        private ?UserDetails $userDetails
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }


    public function email(): string
    {
        return $this->email;
    }

    public function userDetails(): ?UserDetails
    {
        return $this->userDetails;
    }

    /**
     * @param string $phoneNumber
     * @return void
     * @throws UserIsNotEditableException
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->guardUser();
        $this->userDetails->setPhoneNumber($phoneNumber);
    }


    /**
     * @return void
     * @throws UserIsNotEditableException
     */
    public function guardUser(): void
    {
        if (is_null($this->userDetails)) {
            throw new UserIsNotEditableException(
                sprintf(
                    "User with id %s is not editable since it has not yet user details.",
                    $this->id
                )
            );
        }
    }

    public function delete(): void
    {
        if ($this->userDetails()) {
            throw new UserNotDeletableException(sprintf('User with id %s has user details so it cannot be deleted', $this->id()));
        }

        $this->isActive = false;
    }
}
