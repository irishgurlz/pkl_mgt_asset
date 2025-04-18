<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
    protected $fillable = ['status_pengalihan', 'nomor_penyerahan', 'nik', 'dokumen_pengalihan', 'nomor_it', 'nomor_asset', 'tanggal_pengalihan'];

    public function distribution_detail()
    {
        return $this->belongsTo(DistributionDetail::class, 'nomor_penyerahan', 'nomor_penyerahan');
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }


    public function device()
    {
        return $this->belongsTo(Device::class, 'nomor_it', 'nomor_it');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'nomor_asset', 'nomor_asset');
    }
}
