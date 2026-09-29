<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_never_gets_the_default_password(): void
    {
        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'admin@aether.local')->firstOrFail();

        $this->assertFalse(Hash::check('password', $admin->password));
        $this->assertNotNull($admin->email_verified_at);
    }

    public function test_reseeding_does_not_reset_an_existing_password(): void
    {
        $this->seed(AdminUserSeeder::class);
        User::where('email', 'admin@aether.local')->first()->update(['password' => 'my-own-secret']);

        $this->seed(AdminUserSeeder::class);

        $this->assertTrue(Hash::check('my-own-secret', User::where('email', 'admin@aether.local')->first()->password));
    }
}
