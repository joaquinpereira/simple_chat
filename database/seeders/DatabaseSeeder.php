<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Traits\ChatFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use ChatFactory;

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

}
