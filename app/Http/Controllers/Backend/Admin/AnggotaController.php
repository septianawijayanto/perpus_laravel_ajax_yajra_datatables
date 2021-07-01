<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Anggota';
        $list_anggota = Anggota::all();
        if ($request->ajax()) {
            return datatables()->of($list_anggota)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="btn btn-warning btn-xs edit-post"><i class="lnr lnr-pencil"></i> </a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '"  class="delete btn btn-danger btn-xs"><i class="lnr lnr-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // dd($data);
        // return response(json_decode($data));
        return view('admin.anggota.index', compact('title'));
    }
    public function delete($id)
    {
        $post = Anggota::where('id', $id)->delete();
        return response()->json($post);
    }
    public function store(Request $request)
    {
        $id = $request->id;
        $post = Anggota::updateOrCreate(
            ['id' => $id],
            [
                'nama' => $request->nama,
                'username' => $request->username,
                'level' => $request->level,
                'password' => \bcrypt($request->password),
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'agama' => $request->agama,
            ]
        );
        return response()->json($post);
    }
    public function edit($id)
    {
        $where = array('id' => $id);
        $post = Anggota::where($where)->first();
        return response()->json($post);
    }
}
