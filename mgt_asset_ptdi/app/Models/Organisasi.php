<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    //
    use HasFactory;
    protected $table = 'organisasi';
    protected $fillable = ['kode_org', 'nama'];

    public function listEmployee()
    {
        return $this->hasMany(Employee::class, 'kode_org');
    }
}
