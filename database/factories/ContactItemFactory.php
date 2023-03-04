<?php

namespace Database\Factories;

use App\Enums\ContentItemTypeEnum;
use App\Models\Contact;
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
        $type = $this->faker->randomElement(ContentItemTypeEnum::options());
        $value = match ($type) {
            ContentItemTypeEnum::LOCATION->value => $this->faker->city,
            ContentItemTypeEnum::PHONE->value => $this->faker->phoneNumber,
            ContentItemTypeEnum::EMAIL->value => $this->faker->email,
        };

        return [
            'contact_id' => Contact::query()->inRandomOrder()->first()->id,
            'type'       => $type,
            'value'      => $value,
        ];
    }
}
