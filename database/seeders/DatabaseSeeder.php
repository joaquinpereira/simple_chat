<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(25)->create([
            'avatar' => 'https://source.unsplash.com/random/300x300/?face'
        ]);

        $user = User::factory()->create([
             'name' => 'Joaquin Pereira',
             'email' => 'joaquin@email.com',
             'password' => '$2y$10$/ikhAtrjYhnZoa5O.scqo.zukeNsR.RdZaRSNWWcSWj2/lHahRCuq',
             'avatar' => 'https://source.unsplash.com/random/300x300/?face'
        ]);

        $this->createChatRoom('private', $user, 10);

        $this->createChatRoom('room', $user, 4);

        $this->createChatRoom('private_room', $user, 3);
    }

    public function createChatRoom($room_type, $user, $lenght)
    {
        Chat::factory($lenght)->create(['room_type' => $room_type])
            ->each(function($chat, $index) use ($user, $room_type)
        {
            $chat->users()->save($user);

            if($room_type == 'private'){

                $chat->users()->save(User::where(['id' => $index + 1])->first());

            }else{
                for($i = 1; $i < rand(3, 8); $i++){
                    $chat->users()->save(User::where(['id' => rand(1, 25)])->first());
                }
            }

            $this->createMessagesForChatRoom($chat);

        });
    }

    public function createMessagesForChatRoom($chat)
    {
        $chat->users->each(function($user) use($chat){
            Message::factory(rand(3, 8))->create([
                'chat_id' => $chat->id,
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subMinutes(rand(1, 2000))
            ]);
        });
    }
}
