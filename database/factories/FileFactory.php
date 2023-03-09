<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $model = $this->getModel();
        return [
            'url' => $this->faker->url(),
            'mime' => $this->faker->mimeType(),
            'fileable_id' => $model->id,
            'fileable_type' => get_class($model),
        ];
    }

    public function getModel()
    {
        return Message::factory()->create()->first();
    }
}
