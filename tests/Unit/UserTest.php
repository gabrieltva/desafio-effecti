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
      'cpf' => $this->faker->cpf(),
      'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
      'email' => $this->faker->email,
      'phone' => $this->faker->cellPhoneNumber(),
      'cep' => $this->faker->postcode,
      'state' => $this->faker->stateAbbr(),
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->citySuffix,
      'address' => $this->faker->streetAddress,
    ];

    $response = $this->post('/api/users', $userData);

    $response->assertStatus(201);
    $this->assertDatabaseHas('users', $userData);
  }

  public function test_user_creation_requires_name()
  {
    $userData = [
      'cpf' => $this->faker->cpf(),
      'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
      'email' => $this->faker->email,
      'phone' => $this->faker->cellPhoneNumber(),
      'cep' => $this->faker->postcode,
      'state' => $this->faker->stateAbbr(),
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->citySuffix,
      'address' => $this->faker->streetAddress,
    ];

    $response = $this->post('/api/users', $userData);

    $response->assertJsonValidationErrors('name');
  }

  public function test_user_creation_requires_valid_email()
  {
    $userData = [
      'name' => $this->faker->name,
      'cpf' => $this->faker->cpf(),
      'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
      'email' => 'invalid-email',
      'phone' => $this->faker->cellPhoneNumber(),
      'cep' => $this->faker->postcode,
      'state' => $this->faker->stateAbbr(),
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->citySuffix,
      'address' => $this->faker->streetAddress,
    ];

    $response = $this->post('/api/users', $userData);


    $response->assertJsonValidationErrors('email');
  }

  public function test_user_creation_requires_valid_cpf()
  {
    $userData = [
      'name' => $this->faker->name,
      'cpf' => '12345678900',
      'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
      'email' => $this->faker->email,
      'phone' => $this->faker->cellPhoneNumber(),
      'cep' => $this->faker->postcode,
      'state' => $this->faker->stateAbbr(),
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->citySuffix,
      'address' => $this->faker->streetAddress,
    ];

    $response = $this->post('/api/users', $userData);

    $response->assertJsonValidationErrors('cpf');
  }

  public function test_user_creation_requires_valid_phone()
  {
    $userData = [
      'name' => $this->faker->name,
      'cpf' => $this->faker->cpf(),
      'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
      'email' => $this->faker->email,
      'phone' => 'invalid-phone',
      'cep' => $this->faker->postcode,
      'state' => $this->faker->stateAbbr(),
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->citySuffix,
      'address' => $this->faker->streetAddress,
    ];

    $response = $this->post('/api/users', $userData);

    $response->assertJsonValidationErrors('phone');
  }

  public function test_user_creation_requires_valid_cep()
  {
    $userData = [
      'name' => $this->faker->name,
      'cpf' => $this->faker->cpf(),
      'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
      'email' => $this->faker->email,
      'phone' => $this->faker->cellPhoneNumber(),
      'cep' => 'invalid-cep',
      'state' => $this->faker->stateAbbr(),
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->citySuffix,
      'address' => $this->faker->streetAddress,
    ];

    $response = $this->post('/api/users', $userData);

    $response->assertJsonValidationErrors('cep');
  }

  public function test_user_creation_requires_unique_email()
  {
    $existingUser = \App\Models\User::factory()->create([
      'email' => 'existing@example.com',
    ]);

    $userData = [
      'name' => $this->faker->name,
      'cpf' => $this->faker->cpf(),
      'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
      'email' => 'existing@example.com',
      'phone' => $this->faker->cellPhoneNumber(),
      'cep' => $this->faker->postcode,
      'state' => $this->faker->stateAbbr(),
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->citySuffix,
      'address' => $this->faker->streetAddress,
    ];

    $response = $this->post('/api/users', $userData);

    $response->assertJsonValidationErrors('email');
  }

  public function test_user_creation_requires_birth_date()
  {
    $userData = [
      'name' => $this->faker->name,
      'cpf' => $this->faker->cpf(),
      'birth_date' => null,
      'email' => $this->faker->email,
      'phone' => $this->faker->cellPhoneNumber(),
      'cep' => $this->faker->postcode,
      'state' => $this->faker->stateAbbr(),
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->citySuffix,
      'address' => $this->faker->streetAddress,
    ];

    $response = $this->post('/api/users', $userData);

    $response->assertJsonValidationErrors('birth_date');
  }

  public function test_user_creation_requires_valid_state()
  {
    $userData = [
      'name' => $this->faker->name,
      'cpf' => $this->faker->cpf(),
      'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
      'email' => $this->faker->email,
      'phone' => $this->faker->cellPhoneNumber(),
      'cep' => $this->faker->postcode,
      'state' => 'invalid-state',
      'city' => $this->faker->city,
      'neighborhood' => $this->faker->citySuffix,
      'address' => $this->faker->streetAddress,
    ];

    $response = $this->post('/api/users', $userData);

    $response->assertJsonValidationErrors('state');
  }
}
