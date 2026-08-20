<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@vietthang.vn');

        if (User::where('email', $email)->exists()) {
            return;
        }

        $password = env('ADMIN_PASSWORD');
        $generated = false;

        if (blank($password)) {
            $password = Str::password(16);
            $generated = true;
        }

        $user = User::create([
            'name' => 'Quản trị viên',
            'email' => $email,
            'password' => $password,
        ]);

        $user->assignRole('super-admin');

        if ($generated) {
            $this->command?->warn("Tài khoản super-admin đã được tạo: {$email}");
            $this->command?->warn("Mật khẩu (chỉ hiển thị 1 lần, hãy đổi ngay sau khi đăng nhập): {$password}");
        }
    }
}
