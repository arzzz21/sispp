@extends('layouts.app')

@section('page-name','Kuitansi')

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            Kuitansi
        </h1>
    </div>
    <div class="row" style="width:90%; padding-left:10%">
        <div class="col-12">
            <div class="card" id="print">
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-9">
                            <h3>Pembayaran Biaya SPP</h3>
                            <p style="font-size: 18px;font-family:Arial;">
                                NIS : {{ $items[0]->nis_siswa }}<br>
                                Nama : {{ $items[0]->nama_siswa }}
                            </p>
                        </div>
                        <div class="col-3">
                            <div class="d-flex">
                                <p class="ml-auto">
                                    Invoice: <span id="invoice">01/SPP/{{ now()->format('YmdHis') }}</span><br>
                                    Tanggal : {{ now()->format('d-m-Y') }}
                                    Nama : {{ Auth::user()->name }}
                                </p>
                            </div>
                        </div> --}}
                        {{-- <div class="col-9">
                            <div class="d-flex">
                                <p class="ml-auto">
                                    NIS : {{ $items[0]->nis_siswa }}<br>
                                    Nama : {{ $items[0]->nama_siswa }}
                                </p>
                            </div>
                        </div> --}}

                        <table style="width: 100%; font-size: 18px; font-family:Arial;">
                            <thead>
                                <tr>
                                    <td colspan="2"><h3 style="text-align:center;">BUKTI PEMBAYARAN</h3></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 70%; padding-left:20px;">NIS : {{ $items[0]->nis_siswa }}</td>
                                    <td style="width: 30%;">Tanggal : {{ now()->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 70%; padding-left:20px; padding-bottom:10px;">Nama : {{ $items[0]->nama_siswa }}</td>
                                    <td style="width: 30%; padding-bottom:10px;">Kelas : {{ $items[0]->kelas_siswa }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <hr class="bg-color">
                        <table style="width: 100%; font-size: 18px; font-family:Arial;" id="print">
                            <thead style="border: 1px solid black;">
                            <tr>
                                {{-- <th>Tanggal</th> --}}
                                {{-- <th>Nama Siswa</th> --}}
                                <th style="padding-left:20px; width: 70%;">Jenis Pembayaran</th>
                                {{-- <th>Diskon</th> --}}
                                <th>Dibayarkan</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                @if ($item->bayar != 0 )
                                    <tr>
                                        {{-- <td>{{ $item->created_at->format('d-m-Y') }}</td> --}}
                                        <td style="padding-left:20px; width: 70%;">{{ ($item->nama_tagihan) }}</td>
                                        <td>Rp. {{ format_idr($item->bayar) }}</td>
                                        {{-- <td><input type="text" class="form-control" value="{{ $item->created_at->format('d-m-Y') }}"></td> --}}
                                        {{-- <td><input type="text" class="form-control" id="jumlah-0" value="{{ $item->nama_siswa }}"></td> --}}
                                        {{-- <td><input type="text" class="form-control" data-id="0" value="{{ ($item->nama_tagihan) }}"></td> --}}
                                        {{-- <td><input type="text" class="form-control" data-id="0" value="IDR. {{ format_idr($item->diskon) }}"></td> --}}
                                        {{-- <td><input type="text" class="form-control" data-id="0" value="Rp. {{ format_idr($item->bayar) }}"></td> --}}
                                    </tr>
                                @endif
                                @endforeach
                                {{-- <tr id="newrow"></tr> --}}
                            </tbody>
                            <tfoot>
                                <tr style="border-top: 1px solid black;">
                                    <td style="text-align: center;"><b>TOTAL</b></td>
                                    <td><b>Rp. <span id="total">{{ format_idr($total) }}</span></b></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="btn btn-outline-primary col-12 btn-sm" title="tambah baris" id="tambah">
                            <span class="fe fe-plus"></span>
                        </div>
                        <table style="width: 100%; font-size: 18px;">
                            {{-- <tr>
                                <td style="width: 60%"></td>
                                <td style="width: 20%;text-align: right;"><b>TOTAL</b></td>
                                <td style="width: 20%;">Rp. <span id="total">{{ format_idr($total) }}</span></td>
                            </tr> --}}
                            <tr style="border-top: 1px solid black;">
                                <td style="width: 75%; padding-top:10px;"></td>
                                <td style="width: 25%;text-align: left; padding-top:10px;">
                                    <b>Tanda Terima</b>
                                    {{-- <br>
                                    <br>
                                    <p>............................</p> --}}
                                </td>
                                {{-- <td style="width: 20%;text-align: left; padding-top:10px;">
                                    <b>Hormat Kami</b>
                                    <br>
                                    <br>
                                    <p>............................</p>
                                </td> --}}
                            </tr>
                        </table>
                    </div>

                </div>
                <div class="card-footer" id="tombol_cetak">
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary ml-auto" id="cetak">Cetak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        require(['jquery'], function ($) {
            $(document).ready(function () {

            $('#cetak').hide()
            $('.page-title').hide()
            $('#tambah').hide()
            $('#tombol_cetak').hide()
            $('.hapus').hide()
            $('#histori').toggle()

            // window.print()

            // window.onafterprint = function(){
            //         window.close()
            // }

            var css = '@page { size: 21cm 11cm; margin:0;}',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet){
            style.styleSheet.cssText = css;
            } else {
            style.appendChild(document.createTextNode(css));
            }

            head.appendChild(style);

            window.print();
            window.onafterprint = function(){
                    window.close()
            }
        });
        });
    </script>
@endsection
