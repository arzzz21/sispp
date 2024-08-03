<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Kelas;
use App\Models\Periode;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class SiswaImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row)
        {
            if($index != 0 && ($row[0] != '') && ($row[1] != '') && ($row[2] != '')){
                Siswa::create([
                    'nis' => $row[0],
                    'kelas_id' => Kelas::firstOrCreate(['nama' => $row[1]])->id,
                    'nama' => $row[2],
                    'tempat_lahir' => $row[3],
                    'tanggal_lahir' => $row[4],
                    'jenis_kelamin' => $row[5],
                    'alamat' => $row[6],
                    'nama_wali' => $row[7],
                    'telp_wali'=> $row[8],
                    'pekerjaan_wali' => $row[9],
                    'is_yatim' => (($row[10] == 'Yatim') ? '1' : '0'),
                ]);
            }
        }
    }
}
