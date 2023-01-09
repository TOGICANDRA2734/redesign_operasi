<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransaksiPmaController extends Controller
{
    public function index()
    {        
        $data = DB::table('pma_transfer_file')->join('site', 'pma_transfer_file.kodesite', '=', 'site.kodesite')->select('pma_transfer_file.id', 'site.namasite', 'pma_transfer_file.tgl', 'pma_transfer_file.waktu',  'pma_transfer_file.periode', 'pma_transfer_file.sv', 'pma_transfer_file.file')->orderBy('tgl', 'desc')->orderBy('site.kodesite')->orderBy('waktu', 'desc')->paginate(15);

        return view('adminTransaksiPma.index', compact('data'));
    }
}
