<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use \App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //dd(User::all()->random(1)->pluck('id')[0]);
        return [
            'user_id' => User::all()->random(1)->pluck('id')[0],
            'body' => $this->faker->paragraph()
        ];
    }
}
