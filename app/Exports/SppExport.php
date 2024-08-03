<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SppExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaksi::join('siswa','siswa.id','=','transaksi.siswa_id')
                        ->join('kelas','kelas.id','=','siswa.kelas_id')
                        ->join('tagihan','tagihan.id','=','transaksi.tagihan_id')
                        ->select(
                            'siswa.nama as nama_siswa',
                            'kelas.nama as nama_kelas',
                            'tagihan.nama as nama_tagihan',
                            'transaksi.*',
                            )
                        ->orderBy('created_at','desc')
                        ->get();
    }

    public function view(): View
    {
        return view('transaksi.transaksiexport', [
            'transaksi' => $this->collection(),
        ]);
    }
}
