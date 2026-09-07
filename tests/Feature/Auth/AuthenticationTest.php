<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    // ─── Test 1: Halaman login bisa diakses ──────────────────────────────────

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    // ─── Test 2: Admin diarahkan ke /admin/dashboard setelah login ───────────

    public function test_admin_redirected_to_admin_dashboard_after_login(): void
    {
        $admin = User::factory()->create([
            'role'      => 'admin',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email'    => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    // ─── Test 3: Penjual diarahkan ke /penjual/dashboard setelah login ───────

    public function test_penjual_redirected_to_penjual_dashboard_after_login(): void
    {
        $penjual = User::factory()->create([
            'role'      => 'penjual',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email'    => $penjual->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('penjual.dashboard'));
    }

    // ─── Test 4: Akun nonaktif tidak bisa login ──────────────────────────────

    public function test_inactive_user_cannot_login(): void
    {
        $nonaktif = User::factory()->create([
            'role'      => 'penjual',
            'is_active' => false,
        ]);

        $this->post('/login', [
            'email'    => $nonaktif->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    // ─── Test 5: Login gagal dengan password salah ───────────────────────────

    public function test_users_cannot_authenticate_with_wrong_password(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    // ─── Test 6: Logout berhasil ─────────────────────────────────────────────

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    // ─── Test 7: Guest tidak bisa akses /admin/dashboard ─────────────────────

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    // ─── Test 8: Guest tidak bisa akses /penjual/dashboard ───────────────────

    public function test_guest_cannot_access_penjual_dashboard(): void
    {
        $response = $this->get('/penjual/dashboard');
        $response->assertRedirect('/login');
    }

    // ─── Test 9: Penjual mendapat 403 saat akses /admin/dashboard ────────────

    public function test_penjual_cannot_access_admin_dashboard(): void
    {
        $penjual = User::factory()->create([
            'role'      => 'penjual',
            'is_active' => true,
        ]);

        $response = $this->actingAs($penjual)->get('/admin/dashboard');
        $response->assertForbidden();
    }

    // ─── Test 10: Admin mendapat 403 saat akses /penjual/dashboard ───────────

    public function test_admin_cannot_access_penjual_dashboard(): void
    {
        $admin = User::factory()->create([
            'role'      => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/penjual/dashboard');
        $response->assertForbidden();
    }
}
