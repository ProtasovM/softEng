<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\UserNote;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class UserNoteControllerTest extends TestCase
{
    public User $user;
    public string $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            $this->user->id,
            'user',
            '/',
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        $this->token = $this->user->createToken('test')->accessToken;

        $this->assertIsString($this->token);
    }

    /**
     * A basic feature test example.
     */
    public function test403(): void
    {
        $response = $this->getJson('/api/user-notes/');

        $response->assertStatus(403);
    }

    public function testList(): void
    {
        $response = $this->withToken($this->token)
            ->getJson('/api/user-notes/');

        $response->assertStatus(204);
    }

    public function testCreate(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(
                '/api/user-notes/',
                UserNote::factory()->create()->toArray()
            );

        $response->assertStatus(201);
    }
}
