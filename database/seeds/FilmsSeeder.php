<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FilmsSeeder extends Seeder
{
    public function run()
    {
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $faker = Faker\Factory::create();

        //-----------------Film-------------------
        //Best Films
        DB::table('films')->insert([
            'id'=>1,
            'title'=>'Skazani na Shawshank',
            'original_title'=>'The Shawshank Redemption',
            'release'=>Carbon::parse('1994-10-09'),
            'description'=>'Adaptacja opowiadania Stephena Kinga. Niesłusznie skazany na dożywocie bankier, stara się przetrwać w brutalnym, więziennym świecie.',
            'length'=>144,
            'image'=>'uploads/00SNaQo7HsHd6ZKrMQS1xX7CE7dqd1jp8JgKBvZLfv.jpg',
            'poster' => 'uploads/poster-1877221.jpg',
            'video'=>'uploads/TheShawshankRedemption.mp4'
        ]);
        DB::table('films')->insert([
            'id'=>2,
            'title'=>'Nietykalni',
            'original_title'=>'Intouchables',
            'release'=>Carbon::parse('2011-09-23'),
            'description'=>'Sparaliżowany milioner zatrudnia do opieki młodego chłopaka z przedmieścia, który właśnie wyszedł z więzienia.',
            'length' => 112,
            'image'=>'uploads/00q6OGlZ1KMEb14AC8KbPCxyNOal6.jpg',
            'poster' => 'uploads/poster-342.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>3,
            'title'=>'Zielona mila',
            'original_title'=>'The Green Mile',
            'release'=>Carbon::parse('1999-12-06'),
            'description'=>'Emerytowany strażnik więzienny opowiada przyjaciółce o niezwykłym mężczyźnie, którego skazano na śmierć za zabójstwo dwóch 9-letnich dziewczynek.',
            'length' => 188,
            'image'=>'uploads/00sgkhsIHDIOHDIO.png',
            'poster' => 'uploads/poster-7517878.6.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>4,
            'title'=>'Ojciec chrzestny',
            'original_title'=>'The Godfather',
            'release'=>Carbon::parse('1972-03-15'),
            'description'=>'Opowieść o nowojorskiej rodzinie mafijnej. Starzejący się Don Corleone pragnie przekazać władzę swojemu synowi.',
            'length' => 175,
            'image'=>'uploads/00loadkfDIJJSIO.png',
            'poster' => 'uploads/poster-be7324fe2e062e44dc2cfaea67d5a1f1.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>5,
            'title'=>'Dwunastu gniewnych ludzi',
            'original_title'=>'12 Angry Men',
            'release'=>Carbon::parse('1957-04-10'),
            'description'=>'Dwunastu przysięgłych ma wydać wyrok w procesie o morderstwo. Jeden z nich ma wątpliwości dotyczące winy oskarżonego.',
            'length' => 96,
            'image'=>'uploads/00EB20020929REVIEWS08209290301AR.jpg',
            'poster' => 'uploads/poster-12-angry-men-md-web.jpg',
        ]);

        //New Films
        DB::table('films')->insert([
            'id'=>6,
            'title'=>'Batman',
            'original_title'=>'The Batman',
            'release'=>Carbon::parse('2022-03-04'),
            'description'=>'Batman i James Gordon stawiają czoła nieobliczalnemu Człowiekowi-Zagadce w skorumpowanym Gotham City.',
            'length' => 175,
            'image'=>'uploads/da73c76cc37ca8964f4b.png',
            'poster' => 'uploads/poster-7998475.6.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>7,
            'title'=>'Ambulans',
            'original_title'=>'Ambulance',
            'release'=>Carbon::parse('2022-03-18'),
            'description'=>'Dwóch złodziei kradnie karetkę pogotowia po nieudanym napadzie.',
            'length' => 137,
            'image'=>'uploads/ambulance.jpg',
            'poster' => 'uploads/poster-7999496.6.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>8,
            'title'=>'Przeżyć',
            'original_title'=>'Flee',
            'release'=>Carbon::parse('2022-03-18'),
            'description'=>'Prawdziwa historia Amina, który u progu małżeństwa jest zmuszony ujawnić swoją przeszłość.',
            'length' => 90,
            'image'=>'uploads/flee-2021.jpg',
            'poster' => 'uploads/poster-8000136.6.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>9,
            'title'=>'Medium',
            'original_title'=>'Raang Song',
            'release'=>Carbon::parse('2022-03-18'),
            'description'=>'Bogini, która zawładnęła członkiem rodziny, okazuje się nie być tak przyjazna, jak sądzono na początku.',
            'length' => 129,
            'image'=>'uploads/64lahe0w-720.jpg',
            'poster' => 'uploads/poster-8003419.6.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>10,
            'title'=>'Drive My Car',
            'original_title'=>'Drive My Car',
            'release'=>Carbon::parse('2022-03-11'),
            'description'=>'Aktor teatralny i reżyser żyje w szczęśliwym małżeństwie. Pewnego dnia jego żona znika.',
            'length' => 179,
            'image'=>'uploads/1059270_1.1.jpg',
            'poster' => 'uploads/poster-8000632.6.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>11,
            'title'=>'Najgorszy człowiek na świecie',
            'original_title'=>'Verdens verste menneske',
            'release'=>Carbon::parse('2022-03-11'),
            'description'=>'Pełna życiowej energii Julie u progu trzydziestych urodzin stara się poukładać swoje skomplikowane życie uczuciowe.',
            'length' => 128,
            'image'=>'uploads/1055540_1.1.jpg',
            'poster' => 'uploads/poster-7995145.6.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>12,
            'title'=>'Bunkier strachu',
            'original_title'=>'The Bunker Game',
            'release'=>Carbon::parse('2022-03-11'),
            'description'=>'Laura bierze udział w niezwykłej grze, której uczestnicy są zamknięci w ogromnym, wiekowym bunkrze i wcielają się w jedynych ocalałych z nuklearnej zagłady.',
            'length' => 90,
            'image'=>'uploads/60379.4.jpg',
            'poster' => 'uploads/poster-7997954.3.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>13,
            'title'=>'Córka',
            'original_title'=>'The Lost Daughter',
            'release'=>Carbon::parse('2022-03-04'),
            'description'=>'Leda spędza wakacje nad morzem. Musi skonfrontować się ze swoją przeszłością.',
            'length' => 121,
            'image'=>'uploads/33813_1.11.jpg',
            'poster' => 'uploads/poster-7999688.3.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>14,
            'title'=>'Cyrano',
            'original_title'=>'Cyrano',
            'release'=>Carbon::parse('2022-03-04'),
            'description'=>'Cyrano de Bergerac zakochuje się w swojej kuzynce, jednak z przekonania o własnej powierzchowności nie ma odwagi jej tego wyznać.',
            'length' => 124,
            'image'=>'uploads/1055048_1.1.jpg',
            'poster' => 'uploads/poster-7999349.3.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>15,
            'title'=>'Sonata',
            'original_title'=>'Sonata',
            'release'=>Carbon::parse('2022-03-04'),
            'description'=>'To oparta na faktach poruszająca historia Grzegorza Płonki, u którego dopiero w wieku 14 lat stwierdzono niedosłuch, a nie jak wcześniej zakładano – autyzm.',
            'length' => 118,
            'image'=>'uploads/sonata.jpg',
            'poster' => 'uploads/poster-7998476.3.jpg',
        ]);
        DB::table('films')->insert([
            'id'=>16,
            'title'=>'Eden',
            'original_title'=>'Eden',
            'release'=>Carbon::parse('2022-03-04'),
            'description'=>'Film o religijnym obozie letnim opowiadający historię dojrzewania z perspektywy kilkorga młodych ludzi, rozdartych między ideologią, niezależnością i wakacyjną miłością.',
            'length' => 124,
            'image'=>'uploads/1010656.1.jpg',
            'poster' => 'uploads/poster-7924940.3.jpg',
        ]);

        for($i = 17; $i <= 200; $i++){
            $text = rand(100, 400);
            $date = Carbon::now()->subDays(30)->addDays(rand(0, 365));
            DB::table('films')->insert([
                'id'=>$i,
                'title'=>'Film '.$i,
                'original_title'=>'Film '.$i,
                'release'=>$date,
                //'description'=>Str::random($text),
                'description'=>$faker->sentence,
                'length' => 100,
                'image'=>'uploads/Movie_Image.jpg'
            ]);
        }

        //-----------------Actors-------------------
        DB::table('actors')->insert(['id'=>1, 'name'=>'Tim Robbins', 'photo'=>'uploads/actor-Robbins.jpg']);
        DB::table('actors')->insert(['id'=>2, 'name'=>'Morgan Freeman', 'photo'=>'uploads/actor-Freeman.jpg']);
        DB::table('actors')->insert(['id'=>3, 'name'=>'Bob Gunton', 'photo'=>'uploads/actor-Gunton.jpg']);
        DB::table('actors')->insert(['id'=>4, 'name'=>'François Cluzet', 'photo'=>'uploads/actor-Cluzet.jpg']);
        DB::table('actors')->insert(['id'=>5, 'name'=>'Omar Sy', 'photo'=>'uploads/actor-Sy.jpg']);
        DB::table('actors')->insert(['id'=>6, 'name'=>'Anne Le Ny', 'photo'=>'uploads/actor-Ny.jpg']);
        DB::table('actors')->insert(['id'=>7, 'name'=>'Tom Hanks', 'photo'=>'uploads/actor-Hanks.jpg']);
        DB::table('actors')->insert(['id'=>8, 'name'=>'David Morse', 'photo'=>'uploads/actor-Morse.jpg']);
        DB::table('actors')->insert(['id'=>9, 'name'=>'Bonnie Hunt', 'photo'=>'uploads/actor-Hunt.jpg']);
        DB::table('actors')->insert(['id'=>10, 'name'=>'Marlon Brando', 'photo'=>'uploads/actor-Brando.jpg']);
        DB::table('actors')->insert(['id'=>11, 'name'=>'Al Pacino', 'photo'=>'uploads/actor-Pacino.jpg']);
        DB::table('actors')->insert(['id'=>12, 'name'=>'James Caan', 'photo'=>'uploads/actor-Caan.jpg']);
        DB::table('actors')->insert(['id'=>13, 'name'=>'Martin Balsam', 'photo'=>'uploads/actor-Balsam.jpg']);
        DB::table('actors')->insert(['id'=>14, 'name'=>'John Fiedler', 'photo'=>'uploads/actor-Fiedler.jpg']);
        DB::table('actors')->insert(['id'=>15, 'name'=>'Henry Fonda', 'photo'=>'uploads/actor-Fonda.jpg']);


        //-----------------Cast-------------------
        DB::table('casts')->insert(['film_id'=>1, 'actor_id'=>1, 'role'=>'Andy Dufresne']);
        DB::table('casts')->insert(['film_id'=>1, 'actor_id'=>2, 'role'=>'Ellis Boyd "Red" Redding']);
        DB::table('casts')->insert(['film_id'=>1, 'actor_id'=>3, 'role'=>'Naczelnik Samuel Norton']);
        DB::table('casts')->insert(['film_id'=>2, 'actor_id'=>4, 'role'=>'Philippe']);
        DB::table('casts')->insert(['film_id'=>2, 'actor_id'=>5, 'role'=>'Driss']);
        DB::table('casts')->insert(['film_id'=>2, 'actor_id'=>6, 'role'=>'Yvonne']);
        DB::table('casts')->insert(['film_id'=>3, 'actor_id'=>7, 'role'=>'Paul Edgecomb']);
        DB::table('casts')->insert(['film_id'=>3, 'actor_id'=>8, 'role'=>'Brutus "Brutal" Howell']);
        DB::table('casts')->insert(['film_id'=>3, 'actor_id'=>9, 'role'=>'Jan Edgecomb']);
        DB::table('casts')->insert(['film_id'=>4, 'actor_id'=>10, 'role'=>'Don Vito Corleone']);
        DB::table('casts')->insert(['film_id'=>4, 'actor_id'=>11, 'role'=>'Michael Corleone']);
        DB::table('casts')->insert(['film_id'=>4, 'actor_id'=>12, 'role'=>'Sonny Corleone']);
        DB::table('casts')->insert(['film_id'=>5, 'actor_id'=>13, 'role'=>'Przysięgły nr 1']);
        DB::table('casts')->insert(['film_id'=>5, 'actor_id'=>14, 'role'=>'Przysięgły nr 2']);
        DB::table('casts')->insert(['film_id'=>5, 'actor_id'=>15, 'role'=>'Przysięgły nr 8']);

        //-----------------Genres-------------------
        DB::table('genres')->insert(['film_id'=> 1, 'name'=> 'Dramat']);
        DB::table('genres')->insert(['film_id'=> 2, 'name'=> 'Biograficzny']);
        DB::table('genres')->insert(['film_id'=> 2, 'name'=> 'Dramat']);
        DB::table('genres')->insert(['film_id'=> 2, 'name'=> 'Komedia']);
        DB::table('genres')->insert(['film_id'=> 3, 'name'=> 'Dramat']);
        DB::table('genres')->insert(['film_id'=> 4, 'name'=> 'Dramat']);
        DB::table('genres')->insert(['film_id'=> 4, 'name'=> 'Gangsterski']);
        DB::table('genres')->insert(['film_id'=> 5, 'name'=> 'Dramat sądowy']);

        //-----------------Directors-------------------
        DB::table('directors')->insert(['film_id'=> 1, 'name'=> 'Frank Darabont']);
        DB::table('directors')->insert(['film_id'=> 2, 'name'=> 'Olivier Nakache']);
        DB::table('directors')->insert(['film_id'=> 2, 'name'=> 'Éric Toledano']);
        DB::table('directors')->insert(['film_id'=> 3, 'name'=> 'Frank Darabont']);
        DB::table('directors')->insert(['film_id'=> 4, 'name'=> 'Francis Ford Coppola']);
        DB::table('directors')->insert(['film_id'=> 5, 'name'=> 'Sidney Lumet']);

        //-----------------Writers-------------------
        DB::table('writers')->insert(['film_id'=> 1, 'name'=> 'Frank Darabont']);
        DB::table('writers')->insert(['film_id'=> 2, 'name'=> 'Olivier Nakache']);
        DB::table('writers')->insert(['film_id'=> 2, 'name'=> 'Éric Toledano']);
        DB::table('writers')->insert(['film_id'=> 3, 'name'=> 'Frank Darabont']);
        DB::table('writers')->insert(['film_id'=> 4, 'name'=> 'Mario Puzo']);
        DB::table('writers')->insert(['film_id'=> 4, 'name'=> 'Francis Ford Coppola']);
        DB::table('writers')->insert(['film_id'=> 5, 'name'=> 'Reginald Rose']);

        //-----------------Production-------------------
        DB::table('productions')->insert(['film_id'=> 1, 'name'=> 'USA']);
        DB::table('productions')->insert(['film_id'=> 2, 'name'=> 'Francja']);
        DB::table('productions')->insert(['film_id'=> 3, 'name'=> 'USA']);
        DB::table('productions')->insert(['film_id'=> 4, 'name'=> 'USA']);
        DB::table('productions')->insert(['film_id'=> 5, 'name'=> 'USA']);

        //-----------------Photos-------------------

        //-----------------Reviews-------------------
        for($i = 1; $i < 100; $i++){
            $r = rand(7, 10);
            $text = rand(20, 200);
            $bool = rand(0, 1);
            $date = Carbon::now()->subDays(rand(0, 365));
            if($bool) DB::table('reviews')->insert(['film_id'=> 1, 'user_id'=> $i, 'rating' => $r, 'content'=>$faker->sentence, 'created_at' => $date]);
            else DB::table('reviews')->insert(['film_id'=> 1, 'user_id'=> $i, 'rating' => $r, 'created_at' => $date]);
        }
        for($i = 33; $i < 100; $i++){
            $r = rand(5, 8);
            $text = rand(20, 200);
            $bool = rand(0, 1);
            $date = Carbon::now()->subDays(rand(0, 365));
            if($bool) DB::table('reviews')->insert(['film_id'=> 2, 'user_id'=> $i, 'rating' => $r, 'content'=>$faker->sentence, 'created_at' => $date]);
            else DB::table('reviews')->insert(['film_id'=> 2, 'user_id'=> $i, 'rating' => $r, 'created_at' => $date]);
        }
        for($i = 40; $i < 70; $i++){
            $r = rand(6, 9);
            $text = rand(20, 200);
            $bool = rand(0, 1);
            $date = Carbon::now()->subDays(rand(0, 365));
            if($bool) DB::table('reviews')->insert(['film_id'=> 3, 'user_id'=> $i, 'rating' => $r, 'content'=>$faker->sentence, 'created_at' => $date]);
            else DB::table('reviews')->insert(['film_id'=> 3, 'user_id'=> $i, 'rating' => $r, 'created_at' => $date]);
        }
        for($i = 40; $i < 80; $i++){
            $r = rand(6, 10);
            $text = rand(20, 200);
            $bool = rand(0, 1);
            $date = Carbon::now()->subDays(rand(0, 365));
            if($bool) DB::table('reviews')->insert(['film_id'=> 4, 'user_id'=> $i, 'rating' => $r, 'content'=>$faker->sentence, 'created_at' => $date]);
            else DB::table('reviews')->insert(['film_id'=> 4, 'user_id'=> $i, 'rating' => $r, 'created_at' => $date]);
        }
        for($i = 1; $i < 90; $i++){
            $r = rand(5, 10);
            $text = rand(20, 200);
            $bool = rand(0, 1);
            $date = Carbon::now()->subDays(rand(0, 365));
            if($bool) DB::table('reviews')->insert(['film_id'=> 5, 'user_id'=> $i, 'rating' => $r, 'content'=>$faker->sentence, 'created_at' => $date]);
            else DB::table('reviews')->insert(['film_id'=> 5, 'user_id'=> $i, 'rating' => $r, 'created_at' => $date]);
        }
        for($i = 6; $i <= 200; $i++){
            $a = rand(1, 100);
            $b = rand(1, 100);
            if($a < $b) {
                $c = $a;
                $a = $b;
                $b = $c;
            }
            $min = rand(0, 5);
            $max = $min + 4;
            if($max > 10) $max = 10;
            for($j = $b; $j < $a; $j++){
                $r = rand($min, $max);
                $date = Carbon::now()->subDays(rand(0, 120));
                $bool = rand(0, 1);
                if($bool) DB::table('reviews')->insert(['film_id'=> $i, 'user_id'=> $j, 'rating' => $r, 'content'=>$faker->sentence, 'created_at' => $date]);
                else DB::table('reviews')->insert(['film_id'=> $i, 'user_id'=> $j, 'rating' => $r, 'created_at' => $date]);
            }
        }

        //-----------------WantToSee-------------------
        for($i = 12; $i < 100; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('want_to_sees')->insert(['film_id'=> 1, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }
        for($i = 1; $i < 90; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('want_to_sees')->insert(['film_id'=> 2, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }
        for($i = 50; $i < 80; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('want_to_sees')->insert(['film_id'=> 3, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }
        for($i = 90; $i < 100; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('want_to_sees')->insert(['film_id'=> 4, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }
        for($i = 12; $i < 30; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('want_to_sees')->insert(['film_id'=> 5, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }
        for($i = 6; $i <= 200; $i++){
            $a = rand(1, 100);
            $b = rand(1, 100);
            if($a < $b) {
                $c = $a;
                $a = $b;
                $b = $c;
            }
            for($j = $b; $j < $a; $j++){
                $date = Carbon::now()->subDays(rand(0, 120));
                DB::table('want_to_sees')->insert(['film_id'=> $i, 'user_id'=> $j, 'created_at' => $date, 'updated_at' => $date]);
            }
        }

        //-----------------Favourites-------------------
        for($i = 1; $i < 33; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('favourites')->insert(['film_id'=> 1, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }
        for($i = 77; $i < 100; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('favourites')->insert(['film_id'=> 2, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }
        for($i = 1; $i < 40; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('favourites')->insert(['film_id'=> 3, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }
        for($i = 28; $i < 81; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('favourites')->insert(['film_id'=> 4, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }
        for($i = 42; $i < 66; $i++){
            $date = Carbon::now()->subDays(rand(0, 365));
            DB::table('favourites')->insert(['film_id'=> 5, 'user_id'=> $i, 'created_at' => $date, 'updated_at' => $date]);
        }

        for($i = 6; $i <= 16; $i++){
            $a = rand(50, 98);
            $b = 1;
            if($a < $b) {
                $c = $a;
                $a = $b;
                $b = $c;
            }
            for($j = $b; $j < $a; $j++){
                $date = Carbon::now()->subDays(rand(0, 120));
                DB::table('favourites')->insert(['film_id'=> $i, 'user_id'=> $j, 'created_at' => $date, 'updated_at' => $date]);
            }
        }

        for($i = 17; $i <= 200; $i++){
            $a = rand(1, 70);
            $b = 1;
            if($a < $b) {
                $c = $a;
                $a = $b;
                $b = $c;
            }
            for($j = $b; $j < $a; $j++){
                $date = Carbon::now()->subDays(rand(0, 120));
                DB::table('favourites')->insert(['film_id'=> $i, 'user_id'=> $j, 'created_at' => $date, 'updated_at' => $date]);
            }
        }

    }
}
