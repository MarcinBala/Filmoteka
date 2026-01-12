<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsSeeder extends Seeder
{
    public function run()
    {
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $faker = Faker\Factory::create();

        for($i = 1; $i < 100; $i++){
            $date = Carbon::now()->subDays(rand(0, 30));
            $bool = rand(0, 2);
            $category = 'filmy';
            if($bool == 1) $category = 'seriale';
            else if($bool == 2) $category = 'kino';
            DB::table('posts')->insert(['user_id'=> $i, 'title'=>$faker->sentence, 'content'=>$faker->sentence, 'category' => $category, 'created_at' => $date]);
        }

        //likes
        for($i = 1; $i < 100; $i++){
            //users
            for($j = 1; $j < 100; $j++){
                $num = rand(0, 20) + 5;
                $bool = rand(0, 1);
                if($bool == 0) $like = false;
                else $like = true;
                if ($num > 4) DB::table('post_likes')->insert(['post_id'=> $i, 'user_id'=> $j, 'like'=>$bool]);
            }
        }

        for($i = 1; $i < 100; $i++){
            $post = \App\Post::findorFail($i);
            $score = $post->likes()->count() - $post->dislikes()->count();
            $post->score = $score;
            $post->update();
        }
    }
}
