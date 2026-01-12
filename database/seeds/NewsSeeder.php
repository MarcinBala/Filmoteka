<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news')->insert([
            'user_id'=>1,
            'title'=>'Nowy "Spider-Man" największym przebojem Sony w historii',
            'content'=>'Amerykańskie kina przeżywały w ostatnich dniach spore oblężenie. Tylu nowości nie było w pierwszej dziesiątce od czasu wybuchu pandemii. Dystrybutorów nie powstrzymał ani omikron, ani fakt, że Wigilia przypadała w piątek, co zawsze odbija się negatywnie na wpływach.

To właśnie piątkowa Wigilia sprawiała, że "Spider-Man: Bez drogi do domu" nie był w stanie w czasie drugiego weekendu osiągnąć 100 milionów dolarów. Jego spadek w porównaniu do weekendu otwarcia był znaczny i wyniósł aż 69%.

W ostatecznym rozrachunku nie miało to jednak większego znaczenia. "Spider-Man: Bez drogi do domu" zarobił 81,5 mln dolarów, pozostawiając konkurencję daleko w tyle. Widowisko może pochwalić się trzecim najlepszym wynikiem z pierwszego dnia Bożego Narodzenia (31,7 mln dolarów).

Łącznie na jego koncie jest 467,3 mln dolarów. Jest to nowy rekord wpływów osiągnięty przez tytuł studia Sony. Dotychczasowym rekordzistą było "Jumanji: Przygoda w dżungli" (404,5 mln dolarów). Po uwzględnieniu inflacji "Bez drogi do domu" jest numerem cztery na liście hitów wszech czasów studia Sony.

Spośród tytułów pierwszej dziesiątki sprzed tygodnia jeszcze tylko dwa zdołały utrzymać się w Top 10 w miniony weekend. Są to "West Side Story" (2,8 mln dolarów, spadek o 23%) i "Nasze magiczne Encanto" (2 mln dolarów, spadek o 69%). Pozostałe miejsca zajmują premiery i "Licorice Pizza".

Spośród nowości najwyżej znalazła się - zgodnie z oczekiwaniami - muzyczna animacja "Sing 2". Weekendowe wpływy nie wyglądają imponująco - 23,8 mln dolarów. Wpływ Wigilii jest tu ewidentny. Jednak film trafił do kin w środę, do tego miał w listopadzie doskonały wynik na pokazach przedpremierowych. W efekcie po pięciu dniach na koncie filmu jest 41 mln dolarów. Pierwsza część w tym samym czasie zarobiła 55,9 mln dolarów.

"Sing" miało fantastyczne "nogi" i w ostatecznym rozrachunku zarobiło ponad 270 milionów dolarów. Czy "Sing 2" stać na podobny rezultat? W CinemaScore animacja otrzyma perfekcyjną notę A+, czyli widzowie będą sobie ją gorąco polecać. Teraz więc pozostaje jedna niewiadoma: czy rodzice w dobie omikronu będą chcieli chodzić z dziećmi do kin. Jeśli tak, "Sing 2" ma szansę na świetny końcowy wynik.

Fatalny start zaliczyło z kolei widowisko sf "Matrix: Zmartwychwstania". W weekend film zarobił tylko 12 milionów, a od premiery w środę 22,5 mln dolarów. Warner Bros. spodziewało się po pięciu dniach wpływów w okolicach 40 milionów dolarów. Oczywiście widowisku nie pomogło to, że w dobie wysypu zakażeń omikronem można je obejrzeć bezpiecznie bez wychodzenia w domu, na platformie HBO Max. Wydaje się jednak, że poważniejszym problemem był brak zainteresowania ze strony najmłodszych widzów. Seria "Matrix" dla pokolenia poniżej 25 lat nie ma żadnego znaczenia. W efekcie tylko 18% kinowej widowni stanowiły osoby z przedziału wiekowego do 25 roku życia. "Matrix: Zmartwychwstania" nie ma też raczej szans na długie kinowe życie. W CinemaScore otrzymało dość przeciętną notę B-.

Kolejną premierą w pierwszej dziesiątce jest "A Journal for Jordan", czyli dramat z Michaelem B. Jordanem w roli głównej i Denzelem Washingtonem jako reżyserem. Film trafił do kin w piątek i zarobił do niedzieli 2,2 mln dolarów. Jest to najsłabsze otwarcie w szerokiej dystrybucji spośród wszystkich reżyserskich dokonań Washingtona.

Pierwszą dziesiątkę zamyka ostatnia z premier, indyjski film sportowy o krykiecie "83". W 481 kinach zarobił on 1,8 mln dolarów.

Nowością w pierwszej dziesiątce jest też najnowsze dzieło Paula Thomasa Andersona "Licorice Pizza". Po kilku tygodniach obecnościach w zaledwie 4 kinach teraz pokazywany jest w 786 miejscach, co wystarczyło, by wpływy weekendowe wzrosły do 2,3 mln dolarów. Po pięciu tygodniach na jego koncie jest 3,7 mln dolarów.

Źródło: filmweb.pl (https://www.filmweb.pl/news/Box+Office+USA%3A+Nowy+%22Spider-Man%22+najwi%C4%99kszym+przebojem+Sony+w+historii-144978)
',
            'image'=>'uploads/0134857_1.11.jpg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('news')->insert([
            'user_id'=>1,
            'title'=>'Czarna Pantera 2 z nową datą premiery',
            'content'=>'Literacki pierwowzór składa się z historii 43 kobiet wykonujących różnego rodzaje prace fizyczne. Autorka opowiada o zwykłym życiu i chwilach objawień: w pralniach samoobsługowych, w ośrodkach resocjalizacji i w rezydencjach klasy wyższej, wśród telefonistek, zmagających się z życiem matek, autostopowiczów i złych chrześcijan. Berlin skupia się na najbardziej ulotnych momentach życia, wydarzeniach pozornie nieistotnych lub takich, których w codziennej rutynie nie zauważamy (opis wydawcy).',
            'image'=>'uploads/0135171_1.11.jpg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('news')->insert([
            'user_id'=>1,
            'title'=>'Box Office Świat: Batman nowym numerem jeden',
            'content'=>'Koreeda pełni funkcję showrunnera, scenarzysty i reżysera. Scenariusz napisali Koreeda, Sunada Mami, Tsuno Megumi, Okuyama Hiroshi i Sato Takuma. Serial mam mieć 9 odcinków. Oprócz Koreedy za kamerą staną Tsuno Megumi, Okuyama Hiroshi i Sato Takuma. W obsadzie są m.in. Mori Nana, Deguchi Natsuki, Makita Aju, Matsuzaka Keiko i Tokiwa Takako .

Za produkcję odpowiada Netflix oraz studia Story Inc. oraz założone przez Koreedę Bun-Buku. Światową premierę na platformie Netflix zapowiedziano na ten rok.
',
            'image'=>'uploads/0134920_1.11.jpg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('news')->insert([
            'user_id'=>1,
            'title'=>'Scenarzysta "Piątku trzynastego" stał się oficjalnie właścicielem praw do postaci Jasona Voorheesa.',
            'content'=>'Realizację sfinansuje Apple, które coraz prężniej rozwija swój dział produkcji filmowej. Przypomnijmy, że w ubiegłym roku technologiczny gigant z Cupertino wyłożył pieniądze m.in. na nowy film Martina Scorsesego - western "Killers of the Flower Moon" z z Leonardo DiCaprio i Robertem De Niro w rolach głównych. Apple nabyło również prawa do dwóch projektów z udziałem Brada Pitta. W pierwszym - dreszczowcu o parze speców od brudnej roboty - gwiazdor wystąpi u boku swojego dobrego kolegi Georgea Clooneya. Drugi - poświęcony Formule 1 - wyreżyseruje twórca "Top Gun: Maverick" Joseph Kosinski. ',
            'image'=>'uploads/0134952_1.11.jpg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('news')->insert([
            'user_id'=>1,
            'title'=>'Diuna obsypana nagrodami za efekty specjalne',
            'content'=>'Seria gier wideo "Fallout" zadebiutowała w 1997 roku i od tego czasu doczekała się czterech głównych odsłon oraz kilku spin-offów - ostatnia z nich, "Fallout 76" pojawiła się na rynku przed trzema laty.  W 2007 prawa do marki przejęła firma Bethesda i przeniosła serię w trójwymiar, co nie spodobało się wszystkim fanom postapokaliptycznych RPG.

Fabularnie to opowieść o ocalałych z nuklearnej zagłady, którzy na radioaktywnych zgliszczach cywilizacji budują społeczeństwo zorganizowane wokół tzw. Schronów. Klimat gry to połączenie ikonografii lat 50. oraz retro-futurystycznego sci-fiction, a wykreowany z pietyzmem świat zamieszkały jest przez najróżniejsze frakcje i grupy wpływów.  ',
            'image'=>'uploads/0135156_1.11.jpg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        for($i = 1; $i < 30; $i++){
            DB::table('news')->insert([
                'user_id'=>1,
                'title'=>'Top 10 tygodnia na Netflix',
                'content'=>'o w zeszłym tygodniu oglądali użytkownicy Netflixa na całym świecie? Zestawienie najpopularniejszych filmów i seriali na platformie ponownie zostało zdominowane przez dwa wiodące tytuły. Widzom udzieliła się również magia Świąt, gdyż chętnie sięgali po pozycje tematycznie z nimi związane.',
                'image'=>'uploads/0128521_2.11.jpg',
                'created_at' => Carbon::now()->subWeek()->format('Y-m-d H:i:s')
            ]);
        }

        //likes
        for($i = 1; $i < 30; $i++){
            //users
            for($j = 1; $j < 100; $j++){
                $num = rand(0, 20) + 5;
                $bool = rand(0, 1);
                if($bool == 0) $like = false;
                else $like = true;
                if ($num > 4) DB::table('news_likes')->insert(['news_id'=> $i, 'user_id'=> $j, 'like'=>$bool]);
            }
        }

    }
}
