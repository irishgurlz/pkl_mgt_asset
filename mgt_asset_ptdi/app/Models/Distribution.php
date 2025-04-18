<?php

namespace App\Models;
use App\Models\Employee;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;
    protected $table = 'distribution';
    protected $fillable = ['nomor_penyerahan', 'nik', 'lokasi', 'status_pengalihan'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }

    public function history()
    {
        return $this->hasMany(History::class, 'nomor_penyerahan', 'nomor_penyerahan');
    }
    
    public function listDistribusi()
    {
        return $this->hasMany(DistributionDetail::class, 'nomor_penyerahan', 'nomor_penyerahan');
    }
}
