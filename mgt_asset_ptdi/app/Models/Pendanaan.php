<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendanaan extends Model
{
    protected $table = 'pendanaan'; 

    protected $fillable = [
        'no_pmn',
        'deskripsi',
        'tanggal',
        'file_attach'
    ];

    public function assets()
    {
        return $this->hasMany(Assets::class, 'no_pmn', 'no_pmn');
    }
}