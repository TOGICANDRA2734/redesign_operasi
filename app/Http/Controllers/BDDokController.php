<?php

namespace App\Http\Controllers;

use App\Models\Plant_bd_dok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BDDokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Data Utama
        $nom_unit = DB::table("plant_populasi")->select("Nom_unit")->get();
        $kode_bd = DB::table("kode_bd")->select("kode_bd")->get();
        $dok_type = DB::table("plant_status_bd_dok")->select(DB::raw("DISTINCT dok_type"))->get();
        $dok_tiket = DB::table("plant_status_bd")->select('id', 'nom_unit')->where('del', '=', 1)->get();


        return view('bd-harian-dok.create', compact('nom_unit', 'kode_bd', 'dok_type', 'dok_tiket'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tiket' => 'required',
            'dok_type' => 'required',
            'dok_no' => 'required',
            'dok_tgl' => 'required',
            'uraian' => 'required',
            'uraian_bd' => 'required',
            'keterangan' => 'required',
        ]);

        $record = Plant_bd_dok::create([
            'id_tiket'              =>  $request->id_tiket,
            'dok_type'              =>  $request->dok_type,
            'dok_no'                =>  $request->dok_no,
            'dok_tgl'               =>  $request->dok_tgl,
            'uraian'                =>  $request->uraian,
            'uraian_bd'             =>  $request->uraian_bd,
            'keterangan'            =>  $request->keterangan,
        ]);

        if($record){
            return redirect()->route('super_admin.bd-harian-detail.index', ['bd_harian' => $request->id_tiket])->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('super_admin.bd-harian-detail.index', ['bd_harian' => $request->id_tiket])->with(['error' => 'Data Gagal Ditambah!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Data Utama
        $data = Plant_bd_dok::findOrFail($id);
        $nom_unit = DB::table("plant_populasi")->select("Nom_unit")->get();
        $kode_bd = DB::table("kode_bd")->select("kode_bd")->get();
        $dok_type = DB::table("plant_status_bd_dok")->select(DB::raw("DISTINCT dok_type"))->get();
        $dok_tiket = DB::table("plant_status_bd")->select('id', 'nom_unit')->where('del', '=', 1)->get();

        return view('bd-harian-dok.edit', compact('nom_unit', 'kode_bd', 'dok_type', 'dok_tiket','data'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_tiket' => 'required',
            'dok_type' => 'required',
            'dok_no' => 'required',
            'dok_tgl' => 'required',
            'uraian' => 'required',
            'uraian_bd' => 'required',
            'keterangan' => 'required',
        ]);

        $record = Plant_bd_dok::findOrFail($id);
        $fileID = $record->id_tiket;

        $record->update([
            'id_tiket'              =>  $request->id_tiket,
            'dok_type'              =>  $request->dok_type,
            'dok_no'                =>  $request->dok_no,
            'dok_tgl'               =>  $request->dok_tgl,
            'uraian'                =>  $request->uraian,
            'uraian_bd'             =>  $request->uraian_bd,
            'keterangan'            =>  $request->keterangan,
        ]);

        if($record){
            return redirect()->route('super_admin.bd-harian-detail.index', ['bd_harian' => $fileID])->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('super_admin.bd-harian-detail.index', ['bd_harian' => $fileID])->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteData($id)
    {
        $record = Plant_bd_dok::findOrFail($id)->update([
            'del' =>  0,
        ]);

        if($record){
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil Dihapus'
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak berhasil Dihapus'
            ]);
        }
    }
}
