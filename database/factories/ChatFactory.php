<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rooms = ['private' ,'room', 'private_room'];
        $tipe_room = array_rand(['private' ,'room', 'private_room']);
        return [
            'name' => $tipe_room != 'private' ? $this->faker->sentence() : null,
            'avatar_room' => $tipe_room != 'private' ? $this->faker->imageUrl(360, 360) : null,
            'room_type' => $rooms[$tipe_room]
        ];
    }
}
