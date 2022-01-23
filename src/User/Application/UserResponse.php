<?php

declare(strict_types=1);

namespace Bitpanda\User\Application;

use Bitpanda\User\Domain\User;

class UserResponse
{

    private function __construct(
        private readonly int $id,
        private readonly string $email,
        private readonly ?string $firstName,
        private readonly ?string $lastName,
        private readonly ?int $countryId,
        private readonly ?string $phoneNumber
    )
    {

    }

    public static function fromUser(User $user): self
    {
        // Breaking Demeters law for the weird Aggregate on User of User Details.
        // Anyway, Demeters law nowadays is very questionable. but here it directly points
        // to a most probable flaw on the domain.
        return new self(
            $user->id(),
            $user->email(),
            $user->userDetails()?->firstName(),
            $user->userDetails()?->lastName(),
            $user->userDetails()?->countryId(),
            $user->userDetails()?->phoneNumber()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'country_id' => $this->countryId,
            'phone_number' => $this->phoneNumber
        ];
    }

}
