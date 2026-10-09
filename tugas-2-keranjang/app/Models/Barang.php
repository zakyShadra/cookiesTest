<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'harga', 'stok'])]
class Barang extends Model
{
    protected $table = 'barang';
}
