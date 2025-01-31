<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AdminTest extends TestCase
{
    public function test_admin_page_protected() {
        $response = $this->get('/admin/user-management');
        $response->assertStatus(302);

        $activeUser = User::factory()->create(['status' => 'inactive']);
        $this->actingAs($activeUser);
        $response = $this->get('/admin/user-management');
        $response->assertStatus(302);

        $activeUser = User::factory()->create(['status' => 'active']);
        $this->actingAs($activeUser);
        $response = $this->get('/admin/user-management');
        $response->assertStatus(200);
    }
}
