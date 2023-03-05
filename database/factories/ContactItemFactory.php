<?php

namespace Database\Factories;

use App\Enums\ContactItemTypeEnum;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactItem>
 */
class ContactItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(ContactItemTypeEnum::options());
        $value = match ($type) {
            ContactItemTypeEnum::LOCATION->value => $this->faker->city,
            ContactItemTypeEnum::PHONE->value => $this->faker->phoneNumber,
            ContactItemTypeEnum::EMAIL->value => $this->faker->email,
        };

        return [
            'contact_id' => Contact::query()->inRandomOrder()->first()->id
                ?? Contact::factory()->create([
                    'user_id' => User::factory()->create()->id
                ]),
            'type'       => $type,
            'value'      => $value,
        ];
    }
}
