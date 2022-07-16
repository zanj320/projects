<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use \App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Followers>
 */
class FollowersFactory extends Factory
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
            'user_id' => $id,
            'following_id' => User::all()->where('id', '!=', $id)->random(1)->pluck('id')[0],
        ];
    }
}
