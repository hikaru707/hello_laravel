<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        //得到除了用戶id 1以外的用戶
        $followers = $users->slice(1);
        $followers_ids = $followers->pluck('id')->toArray();

        //用戶 id 1 關注除了自己以外的其他用戶
        $user->follow($followers_ids);

        //所有用戶關注用戶1
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
