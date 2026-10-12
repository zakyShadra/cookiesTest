<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokoTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $id = 'USR001', string $username = 'budi'): User
    {
        return User::create([
            'id_user' => $id,
            'nama_lengkap' => 'Budi Santoso',
            'email' => $username.'@example.com',
            'username' => $username,
            'password' => 'rahasia123',
            'no_hp' => '0812',
            'alamat' => 'Bandung',
        ]);
    }

    private function barang(string $id = 'BRG001', int $stok = 5, int $harga = 5000): Product
    {
        return Product::create([
            'id_barang' => $id,
            'nama_barang' => 'Barang '.$id,
            'deskripsi' => 'Deskripsi',
            'harga' => $harga,
            'stok' => $stok,
            'gambar' => 'buku-tulis.svg',
        ]);
    }

    public function test_pengunjung_bisa_melihat_barang_tanpa_login(): void
    {
        $this->barang();

        $this->get('/barang')->assertOk()->assertSee('Barang BRG001');
    }

    public function test_pembelian_wajib_login(): void
    {
        $this->barang();

        $this->post('/keranjang/tambah/BRG001')->assertRedirect('/login');
        $this->get('/keranjang')->assertRedirect('/login');
        $this->post('/checkout')->assertRedirect('/login');
    }

    public function test_login_dengan_password_ter_hash(): void
    {
        $user = $this->user();

        $this->assertNotSame('rahasia123', $user->password);
        $this->post('/login', ['username' => 'budi', 'password' => 'rahasia123'])->assertRedirect('/barang');
        $this->assertAuthenticatedAs($user);
    }

    public function test_barang_stok_nol_tidak_bisa_dibeli(): void
    {
        $this->barang('BRG001', 0);

        $this->actingAs($this->user())->post('/keranjang/tambah/BRG001');

        $this->assertNull(session('keranjang'));
    }

    public function test_jumlah_tidak_boleh_melebihi_stok(): void
    {
        $this->barang('BRG001', 2);
        $this->actingAs($this->user());

        foreach (range(1, 4) as $i) {
            $this->post('/keranjang/tambah/BRG001');
        }
        $this->post('/keranjang/ubah/BRG001/plus');

        $this->assertSame(['BRG001' => 2], session('keranjang'));
    }

    public function test_ubah_jumlah_dan_hapus_barang(): void
    {
        $this->barang('BRG001', 5);
        $this->barang('BRG002', 5);
        $this->actingAs($this->user());

        $this->post('/keranjang/tambah/BRG001');
        $this->post('/keranjang/tambah/BRG002');
        $this->post('/keranjang/ubah/BRG001/plus');
        $this->assertSame(['BRG001' => 2, 'BRG002' => 1], session('keranjang'));

        $this->post('/keranjang/ubah/BRG002/minus');
        $this->post('/keranjang/hapus/BRG001');
        $this->assertSame([], session('keranjang'));
    }

    public function test_checkout_membuat_pesanan_mengurangi_stok_dan_mengosongkan_keranjang(): void
    {
        $this->barang('BRG001', 5, 5000);
        $this->barang('BRG002', 3, 3000);
        $user = $this->user();
        $this->actingAs($user);

        $this->post('/keranjang/tambah/BRG001');
        $this->post('/keranjang/tambah/BRG001');
        $this->post('/keranjang/tambah/BRG002');

        $this->post('/checkout', ['alamat_pengiriman' => 'Jl. Merdeka 10'])->assertRedirect();

        $order = Order::first();
        $this->assertSame('USR001', $order->id_user);
        $this->assertEquals(13000, $order->total_harga);
        $this->assertSame('Jl. Merdeka 10', $order->alamat_pengiriman);
        $this->assertCount(2, $order->details);
        $this->assertEquals(5000, $order->details->firstWhere('id_barang', 'BRG001')->harga_satuan);
        $this->assertSame(2, $order->details->firstWhere('id_barang', 'BRG001')->jumlah_beli);
        $this->assertSame(3, Product::find('BRG001')->stok);
        $this->assertSame(2, Product::find('BRG002')->stok);
        $this->assertNull(session('keranjang'));
    }

    public function test_checkout_gagal_jika_stok_berkurang(): void
    {
        $this->barang('BRG001', 5);
        $this->actingAs($this->user());

        $this->post('/keranjang/tambah/BRG001');
        $this->post('/keranjang/tambah/BRG001');
        Product::find('BRG001')->update(['stok' => 1]);

        $this->post('/checkout', ['alamat_pengiriman' => 'Bandung'])->assertRedirect('/keranjang');

        $this->assertSame(0, Order::count());
        $this->assertSame(1, Product::find('BRG001')->stok);
    }

    public function test_riwayat_hanya_menampilkan_pesanan_milik_sendiri(): void
    {
        $this->barang('BRG001', 5);
        $budi = $this->user('USR001', 'budi');
        $siti = $this->user('USR002', 'siti');

        $this->actingAs($budi)->post('/keranjang/tambah/BRG001');
        $this->post('/checkout', ['alamat_pengiriman' => 'Bandung']);
        $order = Order::first();

        $this->get('/pesanan')->assertOk()->assertSee($order->id_order);
        $this->get('/pesanan/'.$order->id_order)->assertOk()->assertSee('Barang BRG001');

        $this->actingAs($siti)->get('/pesanan')->assertDontSee($order->id_order);
        $this->get('/pesanan/'.$order->id_order)->assertNotFound();
    }
}
