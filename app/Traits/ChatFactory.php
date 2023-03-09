<?php

namespace App\Traits;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;

trait ChatFactory{
    public function createChatRoom($room_type, $user, $n_chats, $createMessages = true, $n_users = 25)
    {
        $chats =Chat::factory($n_chats)->create(['room_type' => $room_type]);

        $chats->each(function($chat, $index) use ($user, $room_type, $createMessages, $n_users)
        {
            $chat->users()->save($user);

            if($room_type == 'private'){

                $chat->users()->save(User::where(['id' => $index + 1])->first());

            }else{
                for($i = 1; $i < rand(3, 8); $i++){
                    $chat->users()->save(User::where(['id' => rand(1, $n_users)])->first());
                }
            }

            if($createMessages)
                $this->createMessagesForChatRoom($chat);

        });

        return $chats;
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
