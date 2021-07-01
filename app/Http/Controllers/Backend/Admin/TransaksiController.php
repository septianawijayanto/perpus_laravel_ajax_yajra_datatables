<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\Anggota;
use App\Models\Model\Buku;
use App\Models\Model\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Transaksi Peminjaman';
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
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="btn btn-warning btn-xs edit-post"><i class="lnr lnr-pencil"></i> </a>';
                    // $button .= '&nbsp;';
                    // $button .= '<a href="/transaksi/' . $data->id . '/kembali" type="button" name="kembalikan"  class="kembalikan btn btn-primary btn-xs"><i class="lnr lnr-trash"></i></a>';
                    return $button;
                })
                ->addColumn('tgl_kembali', function ($data) {
                    return date('d F Y, H:i', strtotime($data->tgl_kembali));
                })
                ->addColumn('tgl_pinjam', function ($data) {
                    return date('d F Y, H:i', strtotime($data->tgl_pinjam));
                })
                ->rawColumns(['status', 'nama', 'judul_buku', 'action', 'tgl_kembali', 'tgl_pinjam'])
                ->make(true);
        }
        return view('admin.peminjaman.index', compact('title', 'buku', 'anggota'));
    }
    public function store(Request $request)
    {
        $id = $request->id;
        $post = Transaksi::updateOrCreate(
            ['id' => $id],
            [
                'kode_transaksi' => $request->kode_transaksi,
                'anggota_id' => $request->anggota_id,
                'buku_id' => $request->buku_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_kembali' => $request->tgl_kembali,
                'status' => 'pinjam',
                'status_denda' => 0,
                'denda' => 0,
            ]
        );
        $idbuku = $post->buku_id;
        $buku = Buku::find($idbuku);
        $saiki = $buku->jumlah;
        $anyar = $saiki - 1;
        $dijilh = $buku->jml_dipinjam;
        $jmlsaiki = $dijilh + 1;
        Buku::where('id', $idbuku)->update([
            'jumlah' => $anyar,
            'jml_dipinjam' => $jmlsaiki,
        ]);
        return response()->json($post);
    }
    public function edit($id)
    {
        $post = Transaksi::where('id', $id)->first();
        return response()->json($post);
    }
}
