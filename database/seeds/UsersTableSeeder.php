<?php

use Faker\Generator as faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $numberOfUsers = 10;
        for ($i = 0; $i < $numberOfUsers; $i++) {

            $newUser = new \App\User();
            $newUser->name = $faker->name;
            $newUser->email = $faker->unique()->safeEmail;
            $newUser->password = bcrypt('password');
            $newUser->created_at = now();
            $newUser->updated_at = now();
            $newUser->save();
        }
    }
}
