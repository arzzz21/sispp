<h2 style="text-align:center"><b> {{ $sitename }} </b></h2 >
    <h3 style="text-align:center">Laporan Harian</h3>
    <p><b>Tanggal :</b> {{ $date }} </p>
<table style="border: 1px solid black; width: 100%">
    <thead style="border: 1px solid black;">
    <tr>
        <th><b>Tanggal</b></th>
        <th><b>NIP</b></th>
        <th><b>Nama</b></th>
        {{-- <th><b>Pembayaran</b></th> --}}
        @foreach ($data['tagihan'] as $index => $tagih)
            <th><b>{{ $tagih->nama }}</b></th>
        @endforeach
        {{-- <th><b>Total</b></th> --}}
    </tr>
    </thead>
    <tbody>
    {{-- <tr class="{{ ($index%2) ? 'gray' : '' }}"> --}}
        @foreach ($data['siswa'] as $index => $item)
            <tr>
                <td>
                    {{ $data['transaksi'][$index]->created_at->format('d-m-Y') }}
                </td>
                <td>{{ $item->nis_siswa}}</td>
                <td>{{ $item->nama_siswa." (".$item->nama_kelas.")" }}</td>
                @foreach ($data['transaksi'] as $tar)
                    @if ($tar->id_siswa == $item->id_siswa)
                        @php
                            $jumlah += $tar->bayar
                        @endphp
                        <td>{{ $tar->bayar }}</td>
                    @endif
                    {{-- @foreach ($data['tagihan'] as $key => $val)
                        @if ($tar->tagihan_id == $val->id)
                            @php
                                $jumlah += $tar->bayar
                            @endphp
                            <td>{{ $tar->bayar }}</td>
                        @endif
                    @endforeach --}}
                @endforeach
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td><b>Total</b></td>
            <td>Rp. {{ format_idr($jumlah) }}</td>
        </tr>
    </tfoot>
</table>
@if(isset($print))
<style>
@media print {
    tr.gray {
        background-color: #ececec !important;
        -webkit-print-color-adjust: exact;
    }
    th {
        background-color: #dadada !important;
        -webkit-print-color-adjust: exact;
    }
}
</style>
<script>
    window.print()
    window.onafterprint = function(){
        window.close()
    }
</script>
@endif
