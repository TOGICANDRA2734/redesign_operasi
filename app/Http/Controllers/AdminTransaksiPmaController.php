<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransaksiPmaController extends Controller
{
    public function index()
    {        
        $data = DB::table('transfer_file_pma')->join('site', 'transfer_file_pma.kodesite', '=', 'site.kodesite')->select('transfer_file_pma.id', 'site.namasite', 'transfer_file_pma.tgl', 'transfer_file_pma.waktu', 'transfer_file_pma.sv', 'transfer_file_pma.file')->orderBy('tgl', 'desc')->orderBy('site.kodesite')->orderBy('waktu', 'desc')->paginate(5);

        return view('adminTransaksiPma.index', compact('data'));
    }
}
