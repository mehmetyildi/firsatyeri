<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factory;
use App\User;
use App\Models\Stick;
use App\Models\Board;
use App\Models\City;
use App\Models\Comment;
use App\Models\District;
use App\Models\Group;
use App\Models\Interest;
use App\Models\Rank;
use App\Models\Wanted;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $faker = Faker\Factory::create();

        for($i = 0; $i < 50; $i++) {
            Interest::create([
                'name' => $faker->word,
                'image_path' => $faker->imageUrl($width = 640, $height = 480)
            ]);
        }


        for($i = 0; $i < 100; $i++) {
            $user=App\User::create([
                'username' => $faker->unique()->userName,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password'=>'12345678',
                'image_url'=>$faker->imageUrl(200, 200, 'people', true, 'Faker'),
                'main_image'=>$faker->imageUrl(1200, 400, 'people', true, 'Faker'),
                'role_id'=>2,
            ]);
            $user->interests()->attach(Interest::all()->random(3));
            for($j=0;$j<$faker->numberBetween($min = 1, $max = 10);$j++){
                $user->boards()->save(
                    $board=new Board([
                        'name'=>$faker->word,
                        'description'=>$faker->sentence,
                    ])
                );
                $board->interests()->attach(Interest::all()->random(3));

                for($k=0;$k<$faker->numberBetween($min = 1, $max = 10);$k++){
                    $city=City::all()->take($faker->numberBetween($min = 1, $max = 81))[0];
                    $number_of_districts=count($city->districts()->get());
                    $district=$city->districts()->get()[$faker->numberBetween($min = 1, $max =$number_of_districts)-1];
                    $before_price=$faker->numberBetween($min=5, $max=1000);
                    $sale_price=$faker->numberBetween($min=$before_price*4/3, $max=$before_price);
                    $end_date=$faker->dateTimeThisYear();
                    $begin_date=$faker->dateTimeThisMonth();
                    $board->sticks()->save(
                        $stick=new Stick([
                            'name'=>$faker->sentence,
                            'content'=>$faker->paragraph,
                            'image_path'=>$faker->imageUrl($width = 640, $height = 480),
                            'city_id'=>$city->id,
                            'district_id'=>$district->id,
                            'before_price'=>$before_price,
                            'sale_price'=>$sale_price,
                            'begin_date'=>$begin_date,
                            'end_date'=>$end_date,
                            'group_id'=>optional()->numberBetween($min=1,$max=20),
                            'user_id'=>$user->id
                        ])
                    );
                    for($l=0;$l<$faker->numberBetween($min = 1, $max = 5);$l++){
                        $user_number=count(User::all());
                        $user=User::find($faker->numberBetween($min=1, $max=$user_number-1));
                        $stick->comments()->save(

                            $comment=new Comment([
                                'content'=>$faker->paragraph,
                                'user_id'=>$user->id,
                            ])
                        );
                    }
                }
            }
        }

        for($i = 0; $i < 20; $i++) {
            $group=Group::create([
                'name' => $faker->word,
                'description' => $faker->paragraph,
                'purpose'=>$faker->sentence,
                'image_path'=>$faker->imageUrl($width = 1200, $height = 400),
                'user_id'=>$faker->numberBetween($min = 1, $max = 50),
                'city_id'=>$faker->numberBetween($min = 1, $max = 81),
            ]);
            $group->interests()->attach(Interest::all()->random(3));
            for($j=0;$j<$faker->numberBetween($min = 1, $max = 5);$j++){
                $group->boards()->save(
                    $board=new Board([
                        'name'=>$faker->word,
                        'description'=>$faker->sentence,
                    ])
                );
                $board->interests()->attach(Interest::all()->random(3));
            }
        }

        $role1=new Role();
        $role1->name='Member';
        $role1->save();
        $role2=new Role();
        $role2->name='Admin';
        $role2->save();

        $rank1=new Rank();
        $rank1->name='Ölücü';
        $rank1->order=1;
        $rank2=new Rank();
        $rank2->name='Cebinde Akrep Var';
        $rank2->order=2;
        $rank3=new Rank();
        $rank3->name='Pazar Müdavimi';
        $rank3->order=3;
        $rank4=new Rank();
        $rank4->name='Sıkı Pazarlıkçı';
        $rank4->order=4;
        $rank5=new Rank();
        $rank5->name='Buralarda Yeni';
        $rank5->order=5;




    }
}
