<?php

namespace Tests\Feature\UserManagement;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;


class UserListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_listing_is_displayed(): void
    {
        $users = User::orderBy('id')->take(5)->get();

        $activeUser = User::factory()->create(['status' => 'active']);
        $this->actingAs($activeUser);
        
        $response = $this->get('/admin/user-management');
        $response->assertStatus(200);

        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }

    public function test_bulk_activate(): void
    {
        $activeUser = User::factory()->create(['status' => 'active']);
        $this->actingAs($activeUser);

        $inactiveUsers = User::factory()->count(3)->create(['status' => 'inactive']);

        $userIDs = $inactiveUsers->pluck('id')->toArray();
 
        $this->post('/admin/user-management/bulk-action', [
            'selected_users' => $userIDs,
            'action' => 'activate',
        ]);
          
        foreach ($userIDs as $id) {
             $user = User::find($id);
             $this->assertEquals('active', $user->status);
         }
    
    }
}
