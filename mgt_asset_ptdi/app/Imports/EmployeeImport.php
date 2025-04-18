<?php
namespace App\Imports;

use App\Models\Employee;
use App\Models\Actor;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EmployeeImport
{
    public function import($file)
    {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
    
        list($headerRowIndex, $headerColumns) = $this->findHeaderRow($sheet);

        foreach ($sheet->getRowIterator($headerRowIndex + 1) as $rowIndex => $row) {
            $data = [];
            $rowValid = true;

            foreach ($row->getCellIterator() as $cellIndex => $cell) {
                $value = $cell->getValue();

                if ($value === null || $value === '') {
                    $data[] = null;
                } else {
                    $columnName = array_search($cellIndex, $headerColumns);
                    $data[$columnName] = $value;
                }
            }

            $relevantData = [
                'nik' => $data['nik'] ?? null,
                'nama' => $data['nama'] ?? null,
                'kode_org' => $data['kode_org'] ?? null,
                'kode_jabatan' => $data['kode_jabatan'] ?? null,
                'password' => $data['password'] ?? null,
            ];

            if (empty(array_filter($relevantData))) {
                \Log::info('Skipping row with missing required fields', ['row' => $data]);
                continue;
            }

            $this->model($data, array_keys($headerColumns));
        }
    }

    public function model(array $row, $expectedHeaders)
    {
        $filteredRow = array_intersect_key($row, array_flip($expectedHeaders));
    
        $relevantData = [
            'nik' => $filteredRow['nik'] ?? null,
            'nama' => $filteredRow['nama'] ?? null,
            'kode_org' => $filteredRow['kode_org'] ?? null,
            'kode_jabatan' => $filteredRow['kode_jabatan'] ?? null,
            'password' => $filteredRow['password'] ?? null,
        ];
    
        if (empty(array_filter($relevantData))) {
            \Log::info('Skipping row with missing required fields', ['row' => $filteredRow]);
            return null;
        }
    
        \Log::info('Extracted data:', $relevantData);
    
        if (count($filteredRow) == count($expectedHeaders)) {
            $data = array_combine($expectedHeaders, $filteredRow);
        } else {
            \Log::warning("Mismatch between row and expected headers length", [
                'row' => $filteredRow,
                'expected_headers' => $expectedHeaders
            ]);
            return null;
        }
    
        $nik = (int)($data['nik'] ?? 0);
        $nama = $data['nama'] ?? null;
        $kode_org = $data['kode_org'] ?? null;
        $kode_jabatan_nama = $data['kode_jabatan'] ?? null;
        $password = Hash::make($data['password'] ?? null);
        
        if (empty($nik) || empty($nama) || empty($kode_org) || empty($kode_jabatan_nama) || empty($password)) {
            \Log::warning('Missing required fields in row:', ['row' => $filteredRow]);
            return null;
        }
    
        $existingEmployee = Employee::where('nik', $nik)->first();
        if ($existingEmployee) {
            \Log::warning("Duplicate entry for nik {$nik}, skipping row", ['row' => $filteredRow]);
            return null;
        }

        $jabatan = Jabatan::where('nama', $kode_jabatan_nama)->first();

        if (!$jabatan) {
            \Log::warning("Jabatan not found for name {$kode_jabatan_nama}, skipping row", ['row' => $filteredRow]);
            return null;
        }

        try {
            $employee = Employee::create([
                'nik' => $nik,
                'nama' => $nama,
                'kode_org' => $kode_org,
                'kode_jabatan' => $jabatan->id,
            ]);
    
            \Log::info('Employee created successfully', ['employee_id' => $employee->id]);
    
            $user_id = $employee->id;
    
            $actor = Actor::create([
                'nik' => $nik,
                'password' => $password,
                'user_id' => $user_id,
                'user_type' => 'Karyawan',
                'role' => 'karyawan'
            ]);
    
            \Log::info('Actor created successfully', ['actor_id' => $actor->id]);
    
        } catch (\Exception $e) {
            \Log::error('Error inserting data:', [
                'error_message' => $e->getMessage(),
                'row' => $filteredRow
            ]);
            return null;
        }
    }
    

    private function findHeaderRow($sheet)
    {
        $knownHeaders = ['nik', 'nama', 'kode_org', 'kode_jabatan', 'password'];

        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $headerFound = [];
            foreach ($cellIterator as $cellIndex => $cell) {
                $columnValue = strtolower($cell->getValue());
                if (in_array($columnValue, $knownHeaders)) {
                    $headerFound[$columnValue] = $cellIndex;
                }
            }

            if (count($headerFound) === count($knownHeaders)) {
                return [$rowIndex, $headerFound];
            }
        }

        return [1, []];
    }
}
