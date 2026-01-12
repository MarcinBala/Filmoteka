<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        for($i = 1; $i < 100; $i++){
            $text = rand(20, 200);
            $date = Carbon::now()->subDays(rand(0, 30));
            DB::table('posts')->insert(['user_id'=> $i, 'title'=>Str::random($text), 'category' => 'filmy', 'created_at' => $date]);
        }*/
    }
}
