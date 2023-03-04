<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contact;
use App\Models\ContactItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        if (! $user = User::query()->where('email', '=', 'test@example.com')->first()) {
             $user = \App\Models\User::factory()->create([
                 'name'      => 'Test User',
                 'last_name' => 'Test Last Name',
                 'email'     => 'test@example.com',
             ]);
        }

        Contact::factory(50)->create([
            'user_id' => $user->id,
        ]);

        ContactItem::factory(100)->create();
    }
}
