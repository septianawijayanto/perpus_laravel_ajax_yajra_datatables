<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\Anggota;
use App\Models\Model\Buku;
use App\Models\Model\Transaksi;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Transaksi Pengembalian';
        $buku = Buku::get();
        $anggota = Anggota::get();
        $list_transaksi = Transaksi::all();
        if ($request->ajax()) {
            return datatables()->of($list_transaksi)->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == 'pinjam') {
                        $badge =   '<span class="label label-primary">' . $data->status . '</span>';
                        return   $badge;
                    } elseif ($data->status == 'kembali') {
                        $badge =   '<span class="label label-success">' . $data->status . '</span>';
                        return   $badge;
                    }
                })
                ->addColumn('nama', function ($data) {
                    return $data->anggota->nama;
                })
                ->addColumn('judul_buku', function ($data) {
                    return $data->buku->judul_buku;
                })
                ->addColumn('aksi', function ($data) {
                    if ($data->status == 'pinjam') {
                        $button = '<a href="/admin/pengembalian/' . $data->id . '/kembali" type="button" name="kembalikan"  class="kembalikan btn btn-primary btn-xs"><i class="fa fa-paper-plane-o"></i></a>';
                        return $button;
                    }
                })
                ->addColumn('tgl_kembali', function ($data) {
                    return date('d F Y, H:i', strtotime($data->tgl_kembali));
                })
                ->addColumn('tgl_pinjam', function ($data) {
                    return date('d F Y, H:i', strtotime($data->tgl_pinjam));
                })
                ->rawColumns(['status', 'nama', 'judul_buku', 'aksi', 'tgl_kembali', 'tgl_pinjam'])
                ->make(true);
        }
        return view('admin.pengembalian.index', compact('title', 'anggota', 'buku'));
    }
    public function kembali($id)
    {
        $post = Transaksi::find($id);
        $idbuku = $post->buku_id;
        $buku = Buku::find($idbuku);
        $saiki = $buku->jumlah;
        $anyar = $saiki + 1;
        $dijilh = $buku->jml_dipinjam;
        $jmlsaiki = $dijilh - 1;
        Buku::where('id', $idbuku)->update([
            'jumlah' => $anyar,
            'jml_dipinjam' => $jmlsaiki,
        ]);
        Transaksi::where('id', $id)->update(['status' => 'kembali']);
        // return view('admin.pengembalian.edit');
        return redirect('admin/pengembalian')->with('sukses', 'Buku Berhasil Dikembalikan');
    }
}
