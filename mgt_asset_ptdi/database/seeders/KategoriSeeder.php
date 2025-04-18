<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::insert([
            ['nama' => 'Laptop', 'jenis_kategori' => '1'],
            ['nama' => 'Processor', 'jenis_kategori' => '0'],
            ['nama' => 'PC Desktop','jenis_kategori' => '1'],
            ['nama' => 'AIO PC', 'jenis_kategori' => '1'],
            ['nama' => 'Storage Type','jenis_kategori' => '0'], 
            ['nama' => 'Memory Type','jenis_kategori' => '0'],
            ['nama' => 'VGA Type', 'jenis_kategori' => '0'],
            ['nama' => 'Operation System', 'jenis_kategori' => '0'],
            ['nama' => 'Office', 'jenis_kategori' => '0'],
            ['nama' => 'License', 'jenis_kategori' => '0'],
            ['nama' => 'Furniture', 'jenis_kategori' => '2'],
            ['nama' => 'Printer', 'jenis_kategori' => '2'],
        ]);
    }
}