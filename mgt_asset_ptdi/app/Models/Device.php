<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{

    protected $table = 'device';

    protected $fillable = [
        'no_pmn',
        'nomor_it',
        'id_kategori',
        'id_tipe',
        'umur',
        'processor',
        'storage_type',
        'storage_capacity',
        'memory_type',
        'memory_capacity',
        'vga_type',
        'vga_capacity',
        'serial_number',
        'operation_system',
        'os_license',
        'office',
        'office_license',
        'aplikasi_lainnya',
        'keterangan_tambahan',
        'kondisi',
        'foto_kondisi'
    ];

    public function pendanaan()
    {
        return $this->belongsTo(Pendanaan::class, 'no_pmn', 'no_pmn');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubKategori::class, 'id_tipe', 'id');
    }

    public function processorType()
    {
        return $this->belongsTo(SubKategori::class, 'processor', 'id');
    }

    public function storageType()
    {
        return $this->belongsTo(SubKategori::class, 'storage_type', 'id');
    }

    public function memoryType()
    {
        return $this->belongsTo(SubKategori::class, 'memory_type', 'id');
    }

    public function vgaType()
    {
        return $this->belongsTo(SubKategori::class, 'vga_type','id');
    }
    public function operationSystem()
    {
        return $this->belongsTo(SubKategori::class, 'operation_system', 'id');
    }

    public function osLicense()
    {
        return $this->belongsTo(SubKategori::class, 'os_license', 'id');
    }
    public function officeType()
    {
        return $this->belongsTo(SubKategori::class, 'office', 'id');
    }

    public function officeLicense()
    {
        return $this->belongsTo(SubKategori::class, 'office_license', 'id');
    }

    public function distribution_detail()
    {
        return $this->belongsTo(DistributionDetail::class, 'nomor_it', 'nomor_it');
    }

}
