<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // use HasFactory;
    protected $table = 'kategori';
    protected $fillable = ['nama', 'jenis_kategori'];

    public function typeKategori()
    {
        return $this->hasMany(TypeKategori::class, 'id_kategori', 'id');
    }
}
