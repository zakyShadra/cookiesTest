<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['id_user', 'nama_lengkap', 'email', 'username', 'password', 'no_hp', 'alamat'])]
#[Hidden(['password'])]
class User extends Authenticatable
{
    protected $primaryKey = 'id_user';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_user', 'id_user');
    }
}
