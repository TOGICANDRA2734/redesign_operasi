<?php

namespace App\Http\Controllers;

use App\Models\plant_status_db_po_transaksi;
use App\Models\PO;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class POTransaksiController extends Controller
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
        $id_tiket_po = PO::select('id', 'no_po')->where('del', 1)->get();

        return view('po-transaksi-harian.create', compact('id_tiket_po'));
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
            'id_tiket_po' => 'required',
            'no_po' => 'required',
            'po_date' => 'required',
            'supplier' => 'required',
            'item' => 'required',
            'no_mrs' => 'required',
            'mrs_date' => 'required',
        ]);


        $record = plant_status_db_po_transaksi::create([
            'id_tiket_po'       =>  $request->id_tiket_po,
            'no_po'             =>  $request->no_po,
            'po_date'           =>  $request->po_date,
            'supplier'          =>  $request->supplier,
            'item'              =>  $request->item,
            'no_mrs'            =>  $request->no_mrs,
            'mrs_date'          =>  $request->mrs_date,
            'del'               =>  1
        ]);

        if($record){
            return redirect()->route('super_admin.po-transaksi-harian.show', $request->id_tiket_po)->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('super_admin.po-transaksi-harian.show', $request->id_tiket_po)->with(['error' => 'Data Gagal Ditambah!']);
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
        $data = plant_status_db_po_transaksi::where('del', 1)->where('id_tiket_po', $id)->get();
        
        // dd($data[0]->no_mrs == "", $data[0]->no_mrs, $data[1]->no_mrs == "", $data[1]->no_mrs);

        return view('po-transaksi-harian.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_tiket_po = PO::select('id', 'no_po')->where('del', 1)->get();
        $data = plant_status_db_po_transaksi::findOrFail($id);

        // dd($data);

        return view('po-transaksi-harian.edit', compact('data', 'id_tiket_po'));
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
            'id_tiket_po' => 'required',
            'no_po' => 'required',
            'po_date' => 'required',
            'supplier' => 'required',
            'item' => 'required',
            'no_mrs' => 'required',
            'mrs_date' => 'required',
        ]);

        $record = plant_status_db_po_transaksi::findOrFail($id);

        $record->update([
            'id_tiket_po'       =>  $request->id_tiket_po,
            'no_po'             =>  $request->no_po,
            'po_date'           =>  $request->po_date,
            'supplier'          =>  $request->supplier,
            'item'              =>  $request->item,
            'no_mrs'            =>  $request->no_mrs,
            'mrs_date'          =>  $request->mrs_date,
        ]);

        if($record){
            return redirect()->route('super_admin.po-harian.show', $request->id_tiket_po)->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else{
            return redirect()->route('super_admin.po-harian.show', $request->id_tiket_po)->with(['error' => 'Data Gagal Diupdate!']);
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
        $record = plant_status_db_po_transaksi::findOrFail($id)->update([
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
