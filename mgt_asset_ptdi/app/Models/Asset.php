<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    protected $table = 'asset';

    protected $fillable = [
        'nomor_asset',
        'no_pmn',
        'id_kategori',
        'id_tipe',
        'umur',
        'foto',
        'kondisi',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubKategori::class, 'id_tipe', 'id');
    }

    public function pendanaan()
    {
        return $this->belongsTo(Pendanaan::class, 'no_pmn', 'no_pmn');
    }

    public function distribution_detail()
    {
        return $this->belongsTo(DistributionDetail::class, 'nomor_asset', 'nomor_asset');
    }

    public function history()
    {
        return $this->hasMany(History::class, 'nomor_asset', 'nomor_asset');
    }
}
