<?php

namespace Tests\Feature\Api;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ContactTest extends TestCase
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
        Passport::actingAs(User::factory()->create());

        $response = $this->get(route('api.v1.contact.index'));

        $response->assertStatus(200);
    }

    public function test_create_contact(): void
    {
        Passport::actingAs(User::factory()->create());

        $payload = Contact::factory()
            ->make()
            ->getAttributes();

        $this->post(route('api.v1.contact.store'), $payload)
            ->assertStatus(201)
            ->assertJson($payload);

        $this->assertDatabaseHas(Contact::class, $payload);
    }

    public function test_update_contact(): void
    {
        Passport::actingAs($user = User::factory()->create());

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $payload = Contact::factory()
            ->make()
            ->getAttributes();

        $this->put(route('api.v1.contact.update', [$contact]), $payload)
            ->assertSuccessful()
            ->assertJson($payload);

        $this->assertDatabaseHas(Contact::class, $payload);
    }

    public function test_delete_contact(): void
    {
        Passport::actingAs($user = User::factory()->create());

        $contact = Contact::factory()->create([
            'user_id' => $user->id
        ]);

        $this->delete(route('api.v1.contact.destroy', [$contact]))
            ->assertSuccessful();

        $this->assertDatabaseMissing(Contact::class, $contact->toArray());
    }
}
