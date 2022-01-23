<?php

declare(strict_types=1);

namespace Bitpanda\User\Domain;

class UserDetails
{

    public function __construct(
        private string $firstName,
        private string $lastName,
        private int $countryId,
        private string $phoneNumber
    )
    {

    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function countryId(): int
    {
        return $this->countryId;
    }

    public function phoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

}
