<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['id_barang', 'nama_barang', 'deskripsi', 'harga', 'stok', 'gambar'])]
class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id_barang';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;
}
