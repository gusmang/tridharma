<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
        $user = new User;
        $user-> name = 'socareta';
        $user-> email = 'hello@wayansukerta.com';
        $user-> password = Hash::make('sktpwd*123');
        $user-> first_name = 'Wayan';
        $user-> last_name = 'Sukerta';
        $user-> role = 'admin';
        $user-> save();
    }
}
