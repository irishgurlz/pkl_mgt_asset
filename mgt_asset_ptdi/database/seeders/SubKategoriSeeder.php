<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubKategori;

class SubKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubKategori::insert([
            ['id_kategori' => 1, 'nama' => 'Asus'],
            ['id_kategori' => 1, 'nama' => 'Dell'],
            ['id_kategori' => 1, 'nama' => 'HP'],
            ['id_kategori' => 2, 'nama' => 'Intel core i5 - 4570 @3.20GHz'],
            ['id_kategori' => 2, 'nama' => 'Intel Core I7-4770, @3,40GHz'],
            ['id_kategori' => 3, 'nama' => 'HP PRODESK 400 G1 SFF'],
            ['id_kategori' => 3, 'nama' => 'HP PRODESK 400 G2 MT'],
            ['id_kategori' => 3, 'nama' => 'Samsung'],
            ['id_kategori' => 4, 'nama' => 'AIO PC'],
            ['id_kategori' => 5, 'nama' => 'Hard Disk Drives'],
            ['id_kategori' => 6, 'nama' => 'Mask Rom'],
            ['id_kategori' => 7, 'nama' => 'VRAM'],
            ['id_kategori' => 8, 'nama' => 'Windows 11'],
            ['id_kategori' => 9, 'nama' => 'MS. Word 2016'],
            ['id_kategori' => 10, 'nama' => 'GENUINE'],
            ['id_kategori' => 10, 'nama' => 'NOT GENUINE'],
            ['id_kategori' => 11, 'nama' => 'Kursi'],
            ['id_kategori' => 11, 'nama' => 'Meja'],
            ['id_kategori' => 12, 'nama' => 'HP'],

        ]);
    }
}