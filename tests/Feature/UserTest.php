<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
  
  use DatabaseMigrations;

  /**
   * Test creating a new user.
   *
   * @return void
   */
  public function test_create_user()
  {
    $userData = User::factory()->make()->toArray();

    $response = $this->post('/api/users', $userData);

    $response->assertStatus(201);
    $this->assertDatabaseHas('users', $userData);
  }

  /**
   * Test updating an existing user.
   *
   * @return void
   */
  public function test_update_user()
  {
    $user = User::factory()->create();

    $updatedData = [
      'name' => 'Updated Name',
      'email' => 'updatedemail@example.com',
      'phone' => '9876543210',
    ];

    $response = $this->put('/api/users/' . $user->id, $updatedData);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', $updatedData);
  }

  /**
   * Test deleting a user.
   *
   * @return void
   */
  public function test_delete_user()
  {
    $user = User::factory()->create();

    $response = $this->delete('/api/users/' . $user->id);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', ['id' => $user->id, 'status' => 0]);
  }

  /**
   * Test retrieving all users.
   *
   * @return void
   */
  public function test_get_all_users()
  {
    $response = $this->get('/api/users');

    $response->assertStatus(200);
    $response->assertJsonStructure([
      '*' => [
        'id',
        'name',
        'cpf',
        'birth_date',
        'email',
        'phone',
        'cep',
        'state',
        'city',
        'neighborhood',
        'address',
        'status',
        'created_at',
        'updated_at',
      ],
    ]);
  }

  /**
   * Test retrieving a specific user.
   *
   * @return void
   */
  public function test_get_user()
  {
    $user = User::factory()->create();

    $response = $this->get('/api/users/' . $user->id);

    $response->assertStatus(200);
    $response->assertJsonFragment([
      'id' => $user->id,
      'name' => $user->name,
      'cpf' => $user->cpf,
      'birth_date' => $user->birth_date,
      'email' => $user->email,
      'phone' => $user->phone,
      'cep' => $user->cep,
      'state' => $user->state,
      'city' => $user->city,
      'neighborhood' => $user->neighborhood,
      'address' => $user->address,
      'updated_at' => $user->updated_at,
      'created_at' => $user->created_at,
    ]);
  }
}