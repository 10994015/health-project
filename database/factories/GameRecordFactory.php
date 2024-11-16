<?php

namespace Database\Factories;

use App\Models\GameRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameRecord>
 */
class GameRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'name' => $this->faker->name,
            'created_at' => $this->faker->dateTimeBetween('2024-12-02 09:10:00', '2024-12-06 16:50:00'),
            'updated_at' => now(),
        ];
    }
    private function generateUniqueStudentId()
    {
        do {
            $student_id = str()->random(8);
        } while (GameRecord::where('student_id', $student_id)->exists());

        return $student_id;
    }
}
