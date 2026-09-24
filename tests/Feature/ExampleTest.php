<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public portal response.
     */
    public function test_the_public_portal_returns_a_successful_response(): void
    {
        $response = $this->get('/publik');

        $response->assertStatus(200);
    }

    /**
     * Test login page returns a successful response for guests.
     */
    public function test_the_login_page_returns_a_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test unauthenticated access to dashboard redirects to login.
     */
    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated admin can render tambah tanah (form-aset) without missing root tag error.
     */
    public function test_admin_can_access_tambah_tanah(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get('/tanah/baru');

        $response->assertStatus(200);
    }

    /**
     * Test authenticated admin can render dashboard without errors.
     */
    public function test_admin_can_access_dashboard(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get('/');

        $response->assertStatus(200);
    }
}
