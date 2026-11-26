<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Demo Pengguna',
                'password' => Hash::make('password'),
            ],
        );

        $user->products()->firstOrCreate(
            ['sku' => 'BRG-001'],
            [
                'name' => 'Keyboard Mekanis',
                'category' => 'Aksesori',
                'description' => 'Keyboard untuk kebutuhan kerja dan belajar.',
                'stock' => 12,
                'price' => 450000,
            ],
        );

        $user->products()->firstOrCreate(
            ['sku' => 'BRG-002'],
            [
                'name' => 'Mouse Nirkabel',
                'category' => 'Aksesori',
                'description' => 'Mouse nirkabel dengan koneksi USB.',
                'stock' => 4,
                'price' => 175000,
            ],
        );

        $user->products()->firstOrCreate(
            ['sku' => 'BRG-003'],
            [
                'name' => 'Buku Catatan',
                'category' => 'Alat Tulis',
                'description' => 'Buku catatan untuk kegiatan sehari-hari.',
                'stock' => 25,
                'price' => 25000,
            ],
        );
    }
}
