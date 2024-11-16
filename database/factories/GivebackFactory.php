<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Giveback>
 */
class GivebackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_record_id'=> $this->faker->numberBetween(1, 1000),
            'student_id' => $this->faker->unique()->numberBetween(10000000, 99999999), // 假設 student_id 是 8 位數字
            'type' => $this->faker->numberBetween(1, 4), // 假設 type 是 1 到 4 之間的數字
            'question_1' => $this->faker->boolean,
            'question_2' => $this->faker->boolean,
            'question_3' => $this->faker->boolean,
            'question_4' => $this->faker->boolean,
            'question_5' => $this->faker->boolean,
            'question_6' => $this->faker->boolean,
            'question_7' => $this->faker->boolean,
            'comment' => $this->faker->sentence,
            'score' => $this->faker->numberBetween(1, 5), // score 為 1 到 5 之間的數字
            'game_seconds' => $this->faker->numberBetween(1, 200), // 假設 game_seconds 是 1 到 3600 之間的數字
            'created_at' => $this->faker->dateTimeBetween('2024-12-02 09:10:00', '2024-12-06 16:50:00'),
            'updated_at' => now(),
        ];
    }
}
