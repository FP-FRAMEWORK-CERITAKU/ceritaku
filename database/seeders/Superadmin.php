<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Superadmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cred = [
            'name' => 'Superadmin',
            'email' => 'super@ceritaku.com',
            'password' => Hash::make('superadmin'),
        ];

        $user = User::create($cred);

        $user->assignRole('Superadmin');
    }
}
