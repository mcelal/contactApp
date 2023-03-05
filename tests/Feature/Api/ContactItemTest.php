<?php

namespace Tests\Feature\Api;

use App\Models\Contact;
use App\Models\ContactItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ContactItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf8',
        ]);
    }

    public function test_list_endpoint(): void
    {
        Passport::actingAs($user = User::factory()->create());

        $contact = Contact::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('api.v1.contact.items.index', [$contact]));

        $response->assertStatus(200);
    }

    public function test_create_contact_item(): void
    {
        Passport::actingAs(User::factory()->create());

        $payload = ContactItem::factory()
            ->make()
            ->getAttributes();

        $this->post(route('api.v1.contact.items.store', [$payload['contact_id']]), $payload)
            ->assertStatus(201)
            ->assertJson($payload);

        $this->assertDatabaseHas(ContactItem::class, $payload);
    }

    public function test_update_contact_item(): void
    {
        Passport::actingAs($user = User::factory()->create());

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $item = ContactItem::factory()->create([
            'contact_id' => $contact->id
        ]);

        $payload = ContactItem::factory()
            ->make()
            ->getAttributes();

        $this->put(route('api.v1.contact.items.update', [$contact, $item]), $payload)
            ->assertSuccessful()
            ->assertJson($payload);

        $this->assertDatabaseHas(ContactItem::class, $payload);
    }

    public function test_delete_contact_item(): void
    {
        Passport::actingAs($user = User::factory()->create());

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $item = ContactItem::factory()->create([
            'contact_id' => $contact->id
        ]);

        $this->delete(route('api.v1.contact.items.destroy', [$contact, $item]))
            ->assertSuccessful();

        $this->assertDatabaseMissing(ContactItem::class, $item->toArray());
    }
}
