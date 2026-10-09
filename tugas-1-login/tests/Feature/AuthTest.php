<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private function buatUser(): User
    {
        return User::create([
            'username' => 'budi',
            'password' => 'rahasia123',
            'nama_lengkap' => 'Budi Santoso',
        ]);
    }

    public function test_password_tersimpan_dalam_bentuk_hash(): void
    {
        $user = $this->buatUser();

        $this->assertNotSame('rahasia123', $user->password);
        $this->assertTrue(password_verify('rahasia123', $user->password));
    }

    public function test_dashboard_tanpa_login_dialihkan_ke_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_login_gagal_menampilkan_pesan_umum(): void
    {
        $this->buatUser();

        $this->from('/login')
            ->post('/login', ['username' => 'budi', 'password' => 'salah'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors(['login' => 'Username atau password salah.']);

        $this->assertGuest();
    }

    public function test_login_username_tidak_ada_pesannya_sama(): void
    {
        $this->from('/login')
            ->post('/login', ['username' => 'tidakada', 'password' => 'apapun'])
            ->assertSessionHasErrors(['login' => 'Username atau password salah.']);
    }

    public function test_login_berhasil_ke_dashboard(): void
    {
        $this->buatUser();

        $this->post('/login', ['username' => 'budi', 'password' => 'rahasia123'])
            ->assertRedirect('/dashboard');

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Selamat datang, Budi Santoso!')
            ->assertSee('Username: budi');
    }

    public function test_pengguna_yang_sudah_login_tidak_bisa_buka_login(): void
    {
        $this->actingAs($this->buatUser())
            ->get('/login')
            ->assertRedirect('/dashboard');
    }

    public function test_logout_hanya_lewat_post_dan_menghapus_sesi(): void
    {
        $this->actingAs($this->buatUser());

        $this->get('/logout')->assertStatus(405);
        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
        $this->get('/dashboard')->assertRedirect('/login');
    }
}
