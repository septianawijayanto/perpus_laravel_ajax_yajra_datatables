<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $title = 'Laporan';
        return view('admin.laporan.index', compact('title'));
    }
}
