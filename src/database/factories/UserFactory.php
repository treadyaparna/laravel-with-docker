<?php
namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = Role::inRandomOrder()->limit(1)->get();
        $roleFrom = $role->first();

        return [
            "name" => fake()->name(),
            "email" => fake()
                ->unique()
                ->safeEmail(),
            "role_id" => $roleFrom->id,
        ];
    }


}
