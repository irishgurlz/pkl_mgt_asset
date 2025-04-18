<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryPengajuan extends Model
{
    protected $table = 'history_pengajuan';
    protected $fillable = ['id_distribution_detail', 'status', 'status_pengajuan'];

    public function distributionDetail()
    {
        return $this->belongsTo(DistributionDetail::class, 'id_distribution_detail', 'id');
    }
}
