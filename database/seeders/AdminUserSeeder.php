<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Create the first admin account from ADMIN_EMAIL / ADMIN_PASSWORD.
     * Never overwrites an existing account, so re-seeding can't reset a password.
     */
    public function run(): void
    {
        $email = config('app.admin.email');

        if (User::where('email', $email)->exists()) {
            $this->command?->info("Admin {$email} already exists — left unchanged.");

            return;
        }

        $password = config('app.admin.password');
        $generated = blank($password);

        if ($generated) {
            $password = Str::password(24, symbols: false);
        }

        User::create([
            'name' => config('app.admin.name'),
            'email' => $email,
            'password' => $password,
        ])->forceFill(['email_verified_at' => now()])->save();

        $this->command?->info("Admin account created: {$email}");

        if ($generated) {
            $this->command?->warn("Generated password (shown once, store it safely): {$password}");
        }
    }
}
