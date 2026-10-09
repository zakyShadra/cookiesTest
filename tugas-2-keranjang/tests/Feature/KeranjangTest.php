<?php

namespace Tests\Feature;

use App\Models\Barang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeranjangTest extends TestCase
{
    use RefreshDatabase;

    public function test_tambah_produk_sama_jumlah_bertambah(): void
    {
        $b = Barang::create(['nama' => 'Buku Tulis', 'harga' => 5000, 'stok' => 10]);

        $this->post("/keranjang/tambah/{$b->id}");
        $this->post("/keranjang/tambah/{$b->id}");

        $this->assertSame([$b->id => 2], session('keranjang'));
        $this->get('/keranjang')->assertSee('Rp 5.000 x 2 = Rp 10.000', false);
    }

    public function test_minus_sampai_nol_menghapus_item(): void
    {
        $b = Barang::create(['nama' => 'Buku Tulis', 'harga' => 5000, 'stok' => 10]);

        $this->post("/keranjang/tambah/{$b->id}");
        $this->post("/keranjang/ubah/{$b->id}/minus");

        $this->assertSame([], session('keranjang'));
    }

    public function test_hapus_satu_item_dan_kosongkan(): void
    {
        $a = Barang::create(['nama' => 'Buku Tulis', 'harga' => 5000, 'stok' => 10]);
        $b = Barang::create(['nama' => 'Pulpen', 'harga' => 3000, 'stok' => 10]);

        $this->post("/keranjang/tambah/{$a->id}");
        $this->post("/keranjang/tambah/{$b->id}");
        $this->post("/keranjang/hapus/{$a->id}");
        $this->assertSame([$b->id => 1], session('keranjang'));

        $this->post('/keranjang/kosongkan');
        $this->assertNull(session('keranjang'));
    }

    public function test_harga_diambil_dari_database(): void
    {
        $b = Barang::create(['nama' => 'Buku Tulis', 'harga' => 5000, 'stok' => 10]);

        $this->withSession(['keranjang' => [$b->id => 3]])
            ->get('/keranjang')
            ->assertSee('Rp 15.000', false);
    }
}
