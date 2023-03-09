<?php

namespace Tests\Unit\Models;

use App\Models\File;
use Tests\TestCase;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Traits\ChatFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase, ChatFactory;

    /** @test */
    public function a_message_belong_to_user()
    {
        $users = User::factory(2)->create();

        $chat = $this->createChatRoom('private', $users->first(), 1 , false, 2)->first();

        $messages = Message::factory(3)->create([
            'user_id' => $users->first()->id,
            'chat_id' => $chat->id,
        ]);

        $this->assertInstanceOf(User::class, $messages->first()->user);
        $this->assertEquals($users->first()->id, $messages->first()->user->id);
        $this->assertNotEquals($users->last()->id, $messages->first()->user->id);
    }

    /** @test */
    public function a_message_belong_to_chat()
    {
        $users = User::factory(2)->create();

        $chats = $this->createChatRoom('private', $users->first(), 2 , false, 2);

        $messages = Message::factory(3)->create([
            'user_id' => $users->first()->id,
            'chat_id' => $chats->first()->id,
        ]);

        $this->assertInstanceOf(Chat::class, $messages->first()->chat);
        $this->assertEquals($chats->first()->id, $messages->first()->chat->id);
        $this->assertNotEquals($chats->last()->id, $messages->first()->user->id);
    }

    /** @test */
    public function a_message_morph_many_files()
    {
        $files = File::factory(3)->for(
            Message::factory(), 'fileable'
        )->create();

        $message = Message::where('id',1)->first();
        $message->files()->firstOrCreate([
            'url' => fake()->url(),
            'mime' => fake()->mimeType()
        ]);

        $this->assertEquals(1, $message->files->count());
        $this->assertNotEquals($files->count(), $message->files->count());

        $this->assertEquals($message->id, $message->files->last()->fileable->id);
        $this->assertInstanceOf(Message::class, $message->files->last()->fileable);
    }
}
