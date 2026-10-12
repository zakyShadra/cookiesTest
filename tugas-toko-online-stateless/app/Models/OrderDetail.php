<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['id_order', 'id_barang', 'harga_satuan', 'jumlah_beli'])]
class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_barang', 'id_barang');
    }
}
