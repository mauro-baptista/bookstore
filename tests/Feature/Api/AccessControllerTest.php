<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AccessControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function fail_to_access_api_if_invalid_token(): void
    {
        User::factory()->create();

        $response = $this->getJson('/api/access/', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer invalid-token',
        ]);

        $response->assertUnauthorized();
    }

    /** @test */
    public function can_access_api_with_valid_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('token');

        $response = $this->getJson('/api/access/', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ]);

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) => $json->where('message', 'success'));
    }
}
