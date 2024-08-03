<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Models\Tagihan;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanHarianExport implements FromView
{

    public function __construct($date, $tanggal)
    {
        $this->date = $date;
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        $siswa = Transaksi::orderBy('transaksi.siswa_id','desc')
                        ->join('siswa','siswa.id','=','transaksi.siswa_id')
                        ->join('kelas','kelas.id','=','siswa.kelas_id')
                        // ->join('tagihan','tagihan.id','=','transaksi.tagihan_id')
                        ->select('transaksi.transaksi_id','siswa.id as id_siswa','siswa.nis as nis_siswa','siswa.nama as nama_siswa','kelas.nama as nama_kelas')
                        ->whereDate('transaksi.created_at', $this->date)
                        ->groupBy('transaksi.transaksi_id','siswa.id','siswa.nis','siswa.nama','kelas.nama')
                        ->get();

        $transaksi = Transaksi::orderBy('transaksi.tagihan_id','asc')
                        ->join('siswa','siswa.id','=','transaksi.siswa_id')
                        ->join('kelas','kelas.id','=','siswa.kelas_id')
                        // ->join('tagihan','tagihan.id','=','transaksi.tagihan_id')
                        ->select('siswa.id as id_siswa','siswa.nama as nama_siswa','kelas.nama as nama_kelas','transaksi.tagihan_id','transaksi.bayar','transaksi.created_at')
                        ->whereDate('transaksi.created_at', $this->date)
                        ->get();

        $tagihan = tagihan::select('id','nama')->get();

        $data = [
            'siswa' => $siswa,
            'transaksi' => $transaksi,
            'tagihan' => $tagihan
        ];
        // print_r($data);
        // die();
        return $data;

        // return Tagihan::all();
    }

    public function view(): View
    {
        return view('dashboard.export', [
            'data' => $this->collection(),
            'date' => $this->date,
            'tanggal' => $this->tanggal,
            'jumlah' => 0
        ]);
    }
}
