<?php

use App\Models\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = \App\User::all();
        for ($i = 0; $i < 10; $i++) {
            $newPost = new Post();
            $newPost->title = $faker->randomElement($users)->name;
            $newPost->user_id = $faker->randomElement($users)->id;
            $newPost->content = $faker->paragraph(4);
            $newPost->image = $faker->imageUrl();
            $newPost->published = $faker->boolean;
            $newPost->published_at = $faker->dateTimeThisMonth();
            $newPost->save();
        }
    }
}
