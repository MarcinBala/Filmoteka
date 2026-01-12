<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        //Password: password

        DB::table('users')->insert([
            'username'=>'Administrator',
            'email'=>'filmotekaadmin@gmail.com',
            'name'=>'Administrator',
            'password'=>'$2y$10$2Vp1B0Px0gsOklfTfsjfVe8mu99QqdqJTvvqNRGy6egxpOahc9c5u',
            'user_type'=>'admin',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        for($i = 2; $i < 50; $i++){
            $r = rand(8, 30);
            $id = $i - 1;
            DB::table('users')->insert([
                'username'=>$faker->userName,
                'email'=> 'filmotekauser' . $id . '@gmail.com',
                'name'=>$faker->userName,
                'password'=>'$2y$10$2Vp1B0Px0gsOklfTfsjfVe8mu99QqdqJTvvqNRGy6egxpOahc9c5u',
                'user_type'=>'user',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        for($i = 50; $i <= 100; $i++){
            $r = rand(8, 30);
            $id = $i - 49;
            DB::table('users')->insert([
                'username'=>$faker->userName,
                'email'=> 'filmotekacritic' . $id . '@gmail.com',
                'name'=>$faker->userName,
                'password'=>'$2y$10$2Vp1B0Px0gsOklfTfsjfVe8mu99QqdqJTvvqNRGy6egxpOahc9c5u',
                'user_type'=>'critic',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
