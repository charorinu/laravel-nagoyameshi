<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /** @test */
    public function test_guest_cannot_access_user_index()
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function test_non_admin_cannot_access_user_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/admin/users');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function test_admin_can_access_user_index()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin, 'admin');
        $response = $this->get('/admin/users');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_guest_cannot_access_user_show()
    {
        $user = User::factory()->create();
        $response = $this->get("/admin/users/{$user->id}");
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function test_non_admin_cannot_access_user_show()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get("/admin/users/{$user->id}");
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function test_admin_can_access_user_show()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $this->actingAs($admin, 'admin');
        $response = $this->get("/admin/users/{$user->id}");
        $response->assertStatus(200);
    }
}
