<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use \App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrivateMessages>
 */
class PrivateMessagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = User::all()->random(1)->pluck('id')[0];

        return [
            'sent_id' => $id,
            'recieved_id' => User::all()->where('id', '!=', $id)->random(1)->pluck('id')[0],
            'body' => Str::random(rand(5, 15))
        ];
    }
}
