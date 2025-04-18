<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\SuperAdmin;
use App\Models\Employee;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    

        $karyawan = Employee::create([
            'nik' => '130013',
            'nama' => 'Edy Prasetyo',
            'kode_org' => 'HD0001',
            'kode_jabatan' => 1,
        ]);

        $karyawan->actors()->create([
            'nik' => '130013',
            'password' => bcrypt('130013'),
            'role' => 'karyawan',
        ]);

        $karyawan = Employee::create([
            'nik' => '140105',
            'nama' => 'Fani Permana Putra',
            'kode_org' => 'HD0001',
            'kode_jabatan' => 1,
        ]);

        $karyawan->actors()->create([
            'nik' => '140105',
            'password' => bcrypt('140105'),
            'role' => 'karyawan',
        ]);

        $admin = Admin::create([
            'nama' => 'Fani Permana Putra',
        ]);

        $admin->actors()->create([
            'nik' => '140105',
            'password' => bcrypt('140105'),
            'role' => 'admin',
        ]);
    
    }
}
