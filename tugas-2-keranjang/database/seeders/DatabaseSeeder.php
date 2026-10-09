<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Buku Tulis', 5000, 50],
            ['Pulpen', 3000, 100],
            ['Penggaris', 4000, 30],
            ['Pensil 2B', 2500, 80],
            ['Penghapus', 1500, 60],
        ];

        foreach ($data as [$nama, $harga, $stok]) {
            Barang::create(['nama' => $nama, 'harga' => $harga, 'stok' => $stok]);
        }
    }
}
