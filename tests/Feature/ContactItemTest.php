<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\ContactItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_page(): void
    {
        $this->actingAs($user = User::factory()->create());

        $contact = Contact::factory()
            ->create([
                'user_id' => $user->id
            ]);

        $response = $this->get(route('contact.edit', [$contact]));

        $response->assertStatus(200);
    }

    public function test_create_contact_item(): void
    {
        $this->actingAs(User::factory()->create());

        $payload = ContactItem::factory()
            ->make()
            ->getAttributes();

        $this->post(route('contact.items.store', [$payload['contact_id']]), $payload)
            ->assertRedirect(route('contact.edit', $payload['contact_id']));

        $this->assertDatabaseHas(ContactItem::class, $payload);
    }

    public function test_update_contact_item(): void
    {
        $this->actingAs($user = User::factory()->create());

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $item = ContactItem::factory()->create([
            'contact_id' => $contact->id
        ]);

        $payload = ContactItem::factory()
            ->make()
            ->getAttributes();

        $this->put(route('contact.items.update', [$contact, $item]), $payload)
            ->assertRedirect(route('contact.edit', [$contact]));

        $this->assertDatabaseHas(ContactItem::class, $payload);
    }

    public function test_delete_contact_item(): void
    {
        $this->actingAs($user = User::factory()->create());

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $item = ContactItem::factory()->create([
            'contact_id' => $contact->id
        ]);

        $this->delete(route('contact.items.destroy', [$contact, $item]))
            ->assertRedirect(route('contact.edit', $contact));

        $this->assertDatabaseMissing(ContactItem::class, $item->toArray());
    }
}
