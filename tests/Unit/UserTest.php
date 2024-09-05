<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class UserTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function test_user_can_be_created()
  {
    $userData = [
      'name' => $this->faker->name,
      'cpf' => $this->faker->numerify('###########'),
      'birth_date' => $this->faker->date,
      'email' => $this->faker->email,
      'phone' => $this->faker->phoneNumber,
      'cep' => $this->faker->postcode,
      'state' => $this->faker->state,
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->streetName,
      'address' => $this->faker->address,
    ];

    $response = $this->post('/users', $userData);

    $response->assertStatus(201);
    $this->assertDatabaseHas('users', $userData);
  }

  public function test_user_creation_requires_name()
  {
    $userData = [
      'cpf' => $this->faker->cpf(),
      'birth_date' => $this->faker->date,
      'email' => $this->faker->email,
      'phone' => $this->faker->phoneNumber,
      'cep' => $this->faker->postcode,
      'state' => $this->faker->state,
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->streetName,
      'address' => $this->faker->address,
    ];

    $response = $this->post('/users', $userData);

    $response->assertSessionHasErrors('name');
  }

  public function test_user_creation_requires_valid_email()
  {
    $userData = [
      'name' => $this->faker->name,
      'cpf' => $this->faker->cpf(),
      'birth_date' => $this->faker->date,
      'email' => 'invalid-email',
      'phone' => $this->faker->phoneNumber,
      'cep' => $this->faker->postcode,
      'state' => $this->faker->state,
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->streetName,
      'address' => $this->faker->address,
    ];

    $response = $this->post('/users', $userData);

    $response->assertSessionHasErrors('email');
  }

  public function test_user_creation_requires_valid_cpf()
  {
    $userData = [
      'name' => $this->faker->name,
      'cpf' => '12345678900',
      'birth_date' => $this->faker->date,
      'email' => $this->faker->email,
      'phone' => $this->faker->phoneNumber,
      'cep' => $this->faker->postcode,
      'state' => $this->faker->state,
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->streetName,
      'address' => $this->faker->address,
    ];

    $response = $this->post('/users', $userData);

    $response->assertSessionHasErrors('cpf');
  }
}