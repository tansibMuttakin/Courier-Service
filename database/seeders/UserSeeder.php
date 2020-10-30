<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Tansib-Al-Muhaimin',
            'email' => 'tansib.muhaimin@northsouth.edu',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'approved'=>1,
        ]);
    }
}
