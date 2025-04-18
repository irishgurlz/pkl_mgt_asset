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
            'nik' => '123456',
            'nama' => 'Sam Smith',
            'kode_org' => 'HD0001',
            'kode_jabatan' => 1,
        ]);

        $karyawan->actors()->create([
            'nik' => '123456',
            'password' => bcrypt('123456'),
            'role' => 'karyawan',
        ]);

        $karyawan = Employee::create([
            'nik' => '098765',
            'nama' => 'John Doe',
            'kode_org' => 'HD0001',
            'kode_jabatan' => 1,
        ]);

        $karyawan->actors()->create([
            'nik' => '098765',
            'password' => bcrypt('098765'),
            'role' => 'karyawan',
        ]);

        $admin = Admin::create([
            'nama' => 'John Doe',
        ]);

        $admin->actors()->create([
            'nik' => '098765',
            'password' => bcrypt('098765'),
            'role' => 'admin',
        ]);
    
    }
}
