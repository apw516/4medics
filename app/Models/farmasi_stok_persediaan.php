<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class farmasi_stok_persediaan extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'farmasi_stok_persediaan';
    protected $connection = 'mysql2';
    protected $guarded = ['id'];
}
