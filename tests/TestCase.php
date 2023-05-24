<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function actingAsUser(): User
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        return $user;
    }

    public function actingAsManager(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('manager');

        Sanctum::actingAs($user, ['*']);
    }
}
