<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Admin' => 'App\Models\Admin',
    'Karyawan' => 'App\Models\Employee',
]);


class Actor extends Authenticatable
{
    use HasFactory;
    protected $table = 'actor';
    protected $primaryKey = 'id';
    protected $fillable = ['nik','password', 'role', 'user_id', 'user_type'];
    
    public function user(){
        return $this->morphTo();
    }

    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKaryawan()
    {
        return $this->role === 'karyawan';
    }

}
