<?php

namespace App\Http\Controllers;

use App\Models\FilePMA;
use App\Models\Site;
use App\Models\TemporaryFiles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index(Request $request)
    {        
        $site = Site::where('status_website', 1)->orderBy('id')->get();
        $data = DB::table('transfer_file_pma')->join('site', 'transfer_file_pma.kodesite', '=', 'site.kodesite')->select('site.namasite', 'transfer_file_pma.tgl', 'transfer_file_pma.waktu', 'transfer_file_pma.sv', 'transfer_file_pma.file')->orderBy('tgl', 'desc')->orderBy('site.kodesite')->orderBy('waktu', 'desc')->paginate(155);

        return view('transferPma.index', compact('site', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'site' => 'required|string',
            'file_pma' => 'required|file|mimes:rar,zip',
        ]);

        $file = $request->file('file_pma');
        // $temporaryFile = TemporaryFiles::where('filename', $request->file->getClientOriginalName())->first();
        $file->storeAs('public/file', Site::select('namasite')->where('kodesite', $request->site)->pluck('namasite')->first() . '_' . Carbon::now()->format('d-m-Y') . '_' . Carbon::now()->format('H:i:s'));

        $record = FilePMA::create([
            'tgl' => date('Y-m-d', strtotime(Carbon::now())),
            'waktu' => date('h:i:s', strtotime(Carbon::now())),
            'file' => $file->hashName(),
            'kodesite' => $request->site,
        ]);

        // $temporaryFile = TemporaryFiles::where('folder', $request->file)->first();
        // if($temporaryFile){
        //     $record->addMedia(storage_path('app/public/filepma/tmp'.$request->file.'/'.$temporaryFile->filename))
        //     ->toMediaCollection('file');
        //     rmdir(storage_path('app/public/filepma/tmp/' . $request->file));
        // }

        if($record){
            return redirect()->route('transferPma.index')->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('transferPma.index')->with(['error' => 'Data Gagal Ditambah!']);
        }
    }

    public function update(Request $request)
    {
        $record = FilePMA::findOrFail($request->idVerif);

        $record->update([
            'sv' => $request->nilaiVerif,
            'tgl_verifikasi' => Carbon::now(),
        ]);

        // dd($record);

        if($record){
            return redirect()->route('super_admin.adminTransaksiPma.index')->with(['success' => 'Data Berhasil Diverifikasi!']);
        }
        else{
            return redirect()->route('super_admin.adminTransaksiPma.index')->with(['error' => 'Data Gagal Diverifikasi!']);
        }
    }
    
}
