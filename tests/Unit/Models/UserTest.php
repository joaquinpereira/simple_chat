<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Traits\ChatFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, ChatFactory;

    /** @test */
    public function a_users_has_many_chats()
    {
        $user = User::factory(2)->create()->first();

        $this->createChatRoom('private', $user, 1 , false);

        $this->assertInstanceOf(Chat::class, $user->chats->first());
    }

    /** @test */
    public function a_users_has_many_messages()
    {
        $user = User::factory(2)->create()->first();

        $this->createChatRoom('private', $user, 1 , true);

        $this->assertInstanceOf(Message::class, $user->messages->first());
    }
}
