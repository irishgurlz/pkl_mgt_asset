<?php

namespace App\Models;
use App\Models\Organisasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'employee';
    protected $fillable = ['nik', 'nama', 'kode_org', 'kode_jabatan'];


    
    public function actors(){
        return $this->morphOne(Actor::class, 'user');
    }

    public function org()
    {
        return $this->belongsTo(Organisasi::class, 'kode_org', 'kode_org');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'kode_jabatan', 'id');
    }

}
