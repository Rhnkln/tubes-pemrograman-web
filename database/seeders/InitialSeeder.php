<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class InitialSeeder extends Seeder
{
    /**
     * Jalankan seeder awal aplikasi
     */
    public function run(): void
    {
        // ===================== ROLES =====================
        // Buat role admin jika belum ada
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrator']
        );

        // Buat role user jika belum ada
        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['description' => 'Pengguna']
        );

        // ===================== ADMIN USER =====================
        // Buat akun admin default jika belum ada
        User::firstOrCreate(
            [
                'email' => 'admin@titiktemu.test',
            ],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin123'),
                'role_id'  => $adminRole->id,
            ]
        );

        // ===================== CATEGORIES =====================
        // Daftar kategori awal
        $categories = [
            [
                'name'        => 'Elektronik',
                'slug'        => 'elektronik',
                'description' => 'Barang elektronik',
                'icon'        => 'fa-solid fa-tv',
            ],
            [
                'name'        => 'Dompet',
                'slug'        => 'dompet',
                'description' => 'Dompet dan sejenisnya',
                'icon'        => 'fa-solid fa-wallet',
            ],
            [
                'name'        => 'Kunci',
                'slug'        => 'kunci',
                'description' => 'Kunci motor/mobil/kamar',
                'icon'        => 'fa-solid fa-key',
            ],
            [
                'name'        => 'Buku',
                'slug'        => 'buku',
                'description' => 'Buku, catatan, dokumen',
                'icon'        => 'fa-solid fa-book',
            ],
            [
                'name'        => 'Lainnya',
                'slug'        => 'lainnya',
                'description' => 'Kategori lain',
                'icon'        => 'fa-solid fa-box',
            ],
        ];

        // Simpan kategori ke database jika belum ada
        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
