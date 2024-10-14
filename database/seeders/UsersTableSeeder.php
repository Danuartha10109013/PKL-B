<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'name' => 'John Doe',
                'no_pegawai' => 'EMP001',
                'jabatan' => 'Manager',
                'alamat' => '123 Main Street',
                'active' => '1',
                'profile' => null,
                'role' => '0',
                'birthday' => '1985-08-25',
                'email' => 'admin@a.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'pegawai',
                'name' => 'Jane Smith',
                'no_pegawai' => 'EMP002',
                'jabatan' => 'Developer',
                'alamat' => '456 Elm Street',
                'active' => '1',
                'profile' => null,
                'role' => '1',
                'birthday' => '1990-12-10',
                'email' => 'pegawai@p.com',
                'email_verified_at' => now(),
                'password' => Hash::make('pegawai'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
