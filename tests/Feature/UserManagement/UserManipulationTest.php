<?php

namespace Tests\Feature\UserManagement;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserStatus;

class UserManipulationTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    

    /**
     * A basic feature test example.
     */
    public function test_create_user(): void
    {
        $activeUser = User::factory()->create(['status' => 'active']);
        $this->actingAs($activeUser);

        $this->setUpFaker();
        $rnd = rand(10, 99);

        $userData = [
            'name' => $this->faker->name(),
            'username' => $rnd . $this->faker->userName(),
            'email' => $rnd . $this->faker->safeEmail(),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'status' => UserStatus::ACTIVE->value,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        
        $response = $this->post('/admin/user-management', $userData);
        
        unset($userData['password']);
        unset($userData['password_confirmation']);
        $createdUser = User::where($userData)->first();

        $this->assertNotNull($createdUser);

        $response->assertRedirect("/admin/user-management/{$createdUser->id}/edit");

    }
    public function test_update_user(): void
    {
        $user = User::factory()->create();

        $activeUser = User::factory()->create(['status' => 'active']);
        $this->actingAs($activeUser);

        $this->setUpFaker();
        $rnd = rand(10, 99);

        $updatedUserData = [
            'name' => $this->faker->name(),
            'username' => $rnd . $this->faker->userName(),
            'email' => $rnd . $this->faker->safeEmail(),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'status' => UserStatus::INACTIVE->value,
        ];
        $response = $this->put("/admin/user-management/{$user->id}", $updatedUserData);

        $response->assertRedirect('/admin/user-management');

        $updatedUserData['id']  = $user->id;
        $this->assertDatabaseHas('users', $updatedUserData);
    }
    public function test_delete_user(): void
    {
        $userToDelete = User::factory()->create();

        $activeUser = User::factory()->create(['status' => 'active']);
        $this->actingAs($activeUser);

        $response = $this->delete("/admin/user-management/{$userToDelete->id}");

        $response->assertRedirect('/admin/user-management');

        $this->assertSoftDeleted('users', ['id' => $userToDelete->id]);
    }
}
