<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class EditUserTest extends TestCase
{
    use RefreshDatabase;

    public function testPhoneNumberGetsEdited(): void
    {
        $newPhoneNumber =  "new phone number";
        $response = $this->put(
            '/api/v1/users/1',
            [
                [
                    'phone_number' => $newPhoneNumber
                ]
            ]

        );

        $response
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

}
