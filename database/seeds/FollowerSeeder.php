<?php

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\User;
use App\Models\Stick;
use App\Models\Board;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users=User::all();
        foreach ($users as $user){
            $random_users=User::all()->random(3);
            foreach ($random_users as $random_user){
                $user->follow($random_user->username);
            }
        }
        $from_istanbul=User::where('location',40)->get();
        foreach ($from_istanbul as $item){
            $item->groups()->attach(Group::all()->random(3));
        }

        $sticks=Stick::all();
        foreach ($sticks as $stick){
            $sticks->boards()->attach(Board::all()->random(3));
        }

    }
}
