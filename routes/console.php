<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Command to safely reset admin password (bypasses tinker and shell_exec restrictions).
 */
Artisan::command('admin:reset {password=Admin12345}', function (string $password = 'Admin12345') {
    $user = User::where('role', User::ROLE_ADMIN)
        ->orWhere('email', 'admin@visiyosindo.com')
        ->first();

    if (!$user) {
        $this->error('User admin tidak ditemukan di database.');
        return;
    }

    $user->password = Hash::make($password);
    $user->is_active = true;
    $user->save();

    $this->info('=========================================');
    $this->info('✓ Password Super Admin Berhasil Direset!');
    $this->line("Email        : {$user->email}");
    $this->line("Password Baru: {$password}");
    $this->info('=========================================');
})->purpose('Reset super admin password safely without tinker');
