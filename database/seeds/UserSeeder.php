<?php

use App\User;
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
        factory(User::class, 10)->create();

        DB::table('users')->insert([
            'name' => 'mohamed_alaa',
            'email' => 'mohamed@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
