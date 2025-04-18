<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributionDetail extends Model
{
    protected $table = 'distribution_detail'; 
    protected $fillable = ['nomor_penyerahan', 'tanggal', 'deskripsi', 'file', 'nomor_it', 'nomor_asset', 'nik', 'lokasi', 'status_pengalihan', 'status_pengajuan', 'status_penerimaan', 'deskripsi_pengajuan'];

    public function device()
    {
        return $this->belongsTo(Device::class, 'nomor_it', 'nomor_it');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'nomor_asset', 'nomor_asset');
    }

    public function distribution()
    {
        return $this->belongsTo(Distribution::class, 'nomor_penyerahan', 'nomor_penyerahan');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }

    public function histories()
    {
        return $this->hasMany(HistoryPengajuan::class, 'id_distribution_detail', 'id');
    }
}
