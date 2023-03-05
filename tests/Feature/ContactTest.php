<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_page(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get(route('contact.index'));

        $response->assertStatus(200);
    }

    public function test_create_contact(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('contact.create'))
            ->assertSuccessful();

        $payload = Contact::factory()
            ->make()
            ->getAttributes();

        $this->post(route('contact.store'), $payload)
            ->assertRedirect(route('contact.index'));

        $this->assertDatabaseHas(Contact::class, $payload);
    }

    public function test_update_contact(): void
    {
        $this->actingAs($user = User::factory()->create());

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $this->get(route('contact.edit', $contact))
            ->assertSuccessful();

        $payload = Contact::factory()
            ->make()
            ->getAttributes();

        $this->put(route('contact.update', $contact), $payload)
            ->assertRedirect(route('contact.edit', $contact));

        $this->assertDatabaseHas(Contact::class, $payload);
    }

    public function test_delete_contact(): void
    {
        $this->actingAs($user = User::factory()->create());

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $this->delete(route('contact.destroy', $contact))
            ->assertRedirect(route('contact.index'));

        $this->assertDatabaseMissing(Contact::class, $contact->toArray());
    }
}
