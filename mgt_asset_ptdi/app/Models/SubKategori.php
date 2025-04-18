<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubKategori extends Model
{
    use HasFactory;
    protected $table = 'sub_kategori';
    protected $fillable = ['id_kategori', 'nama'];


    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function devProcessor()
    {
        return $this->hasMany(Device::class, 'processor');
    }
    public function devStorageType()
    {
        return $this->hasMany(Device::class, 'storage_type');
    }
    public function devMemoryType()
    {
        return $this->hasMany(Device::class, 'memory_type');
    }
    public function devVgaType()
    {
        return $this->hasMany(Device::class, 'vga_type');
    }
    public function devOperationSystem()
    {
        return $this->hasMany(Device::class, 'operation_system');
    }
    public function devOsLicense()
    {
        return $this->hasMany(Device::class, 'os_license');
    }
    public function devOffice()
    {
        return $this->hasMany(Device::class, 'office');
    }
    public function devOfficeLicense()
    {
        return $this->hasMany(Device::class, 'office_license');
    }

    
}
