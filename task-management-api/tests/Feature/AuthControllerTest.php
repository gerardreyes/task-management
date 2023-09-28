<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // Import the User model

class AuthControllerTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    /**
     * Test user registration.
     *
     * @return void
     */
    public function test_register()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201); // Ensure it's a successful creation response
        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }

    /**
     * Test user registration with invalid data.
     *
     * @return void
     */
    public function test_register_with_invalid_data()
    {
        $invalidData = [
            'name' => '', // Invalid: Name is required.
            'email' => 'invalid-email', // Invalid: Invalid email format.
            'password' => 'short', // Invalid: Password should be at least 8 characters.
        ];

        $response = $this->postJson('/api/register', $invalidData);

        $response->assertStatus(400); // Expect a validation error response
    }

    /**
     * Test user registration with duplicate email.
     *
     * @return void
     */
    public function test_register_with_duplicate_email()
    {
        $existingUser = User::factory()->create([
            'email' => 'existing-email@example.com',
        ]);

        $duplicateData = [
            'name' => 'John Doe',
            'email' => 'existing-email@example.com', // Invalid: Duplicate email.
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $duplicateData);

        $response->assertStatus(400); // Expect a validation error response
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('testpassword'),
        ]);

        $data = [
            'email' => 'testuser@example.com',
            'password' => 'testpassword',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(200); // Ensure it's a successful response
        $response->assertJsonStructure(['token']); // Ensure a token is returned
    }

    /**
     * Test user login with incorrect credentials.
     *
     * @return void
     */
    public function test_login_with_incorrect_credentials()
    {
        $invalidCredentials = [
            'email' => 'nonexistent@example.com', // Invalid: User does not exist.
            'password' => 'incorrect-password', // Invalid: Incorrect password.
        ];

        $response = $this->postJson('/api/login', $invalidCredentials);

        $response->assertStatus(401); // Expect an unauthorized error response
    }
}
