<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Traits\ChatFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatTest extends TestCase
{
    use RefreshDatabase, ChatFactory;

    /** @test */
    public function a_chat_belongs_to_many_users()
    {
        $users = User::factory(2)->create();

        $this->createChatRoom('private', $users->first(), 1 , false, 2);

        $chat = Chat::find(1)->first();

        $this->assertInstanceOf(User::class, $chat->users->first());
        $this->assertInstanceOf(User::class, $chat->users->last());
    }

    /** @test */
    public function a_chat_has_many_messages()
    {
        $users = User::factory(5)->create();

        $this->createChatRoom('private', $users->first(), 1 , true, 5);

        $chat = Chat::find(1)->first();

        $this->assertInstanceOf(Message::class, $chat->messages->first());
        $this->assertInstanceOf(Message::class, $chat->messages->last());
    }
}
