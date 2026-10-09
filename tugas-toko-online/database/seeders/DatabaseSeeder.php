<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_user' => 'USR001',
            'nama_lengkap' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'username' => 'budi',
            'password' => 'budi123',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10, Bandung',
        ]);

        User::create([
            'id_user' => 'USR002',
            'nama_lengkap' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'username' => 'siti',
            'password' => 'siti123',
            'no_hp' => '081298765432',
            'alamat' => 'Jl. Dago No. 5, Bandung',
        ]);

        $barang = [
            ['BRG001', 'Buku Tulis', 'Buku tulis 38 lembar', 5000, 50, 'buku-tulis.svg'],
            ['BRG002', 'Pulpen', 'Pulpen tinta hitam', 3000, 100, 'pulpen.svg'],
            ['BRG003', 'Pensil 2B', 'Pensil 2B untuk ujian', 2500, 80, 'pensil.svg'],
            ['BRG004', 'Penghapus', 'Penghapus karet putih', 1500, 60, 'penghapus.svg'],
            ['BRG005', 'Penggaris', 'Penggaris plastik 30 cm', 4000, 30, 'penggaris.svg'],
            ['BRG006', 'Spidol', 'Spidol whiteboard hitam', 8000, 25, 'spidol.svg'],
            ['BRG007', 'Stabilo', 'Penanda teks warna kuning', 7000, 40, 'stabilo.svg'],
            ['BRG008', 'Tip-X', 'Cairan koreksi', 6000, 20, 'tipex.svg'],
            ['BRG009', 'Rautan', 'Rautan pensil logam', 2000, 0, 'rautan.svg'],
            ['BRG010', 'Map Plastik', 'Map plastik transparan', 3500, 45, 'map.svg'],
        ];

        foreach ($barang as [$id, $nama, $deskripsi, $harga, $stok, $gambar]) {
            Product::create([
                'id_barang' => $id,
                'nama_barang' => $nama,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'stok' => $stok,
                'gambar' => $gambar,
            ]);
        }
    }
}
