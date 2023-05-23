<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function actingAsManager(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('manager');
        $this->actingAs($user);
    }
}
