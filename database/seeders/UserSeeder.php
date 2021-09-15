<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin
        DB::table('users')->insert([
            'name' => 'JuanPi',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //Cliente
        DB::table('users')->insert([
            'name' => 'Cliente',
            'email' => 'client@client.com',
            'password' => Hash::make('testlaravel'),
            'rol' => 'client',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
