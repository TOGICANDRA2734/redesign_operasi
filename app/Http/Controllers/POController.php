<?php

namespace App\Http\Controllers;

use App\Models\Plant_bd;
use App\Models\Plant_bd_dok;
use App\Models\PO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_tiket_po = Plant_bd_dok::select('id')->where('del', 1)->get();

        return view('po-harian.create', compact('id_tiket_po'));
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
            'dok_po' => 'required',
            'no_po' => 'required',
            'tgl_po' => 'required',
            'dealer_po' => 'required',
        ]);

        $record = PO::create([
            'id_tiket_po'   =>  $request->id_tiket_po,
            'no_po'   =>  $request->no_po,
            'dok_po'        =>  $request->dok_po,
            'tgl_po'        =>  $request->tgl_po,
            'dealer_po'     =>  $request->dealer_po,
            'del'           =>  1,
        ]);

        if($record){
            return redirect()->route('super_admin.po-harian.show', $request->id_tiket_po)->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('super_admin.po-harian.show', $request->id_tiket_po)->with(['error' => 'Data Gagal Ditambah!']);
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
        $data = PO::where('del', '=', 1)->where('id_tiket_po', $id)->get();

        if(count($data) != 0){
            $dataDok = Plant_bd_dok::select('id_tiket','dok_no')->where('id', $data[0]->id_tiket_po)->get();
            $dataBD = Plant_bd::select('kodesite')->where('id', $dataDok[0]->id_tiket)->get();    
        }
        else{ 
            $dataDok = 1;
            $dataBD = 1;
        }

        
        return view('po-harian.show', compact('data', 'dataDok', 'dataBD'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_tiket_po = Plant_bd_dok::select('id')->where('del', 1)->get();
        $data = PO::findOrFail($id);

        // dd($data);

        return view('po-harian.edit', compact('data', 'id_tiket_po'));
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
            'dok_po' => 'required',
            'no_po' => 'required',
            'tgl_po' => 'required',
            'dealer_po' => 'required',
        ]);

        $record = PO::findOrFail($id);

        $record->create([
            'id_tiket_po'   =>  $request->id_tiket_po,
            'no_po'         =>  $request->no_po,
            'dok_po'        =>  $request->dok_po,
            'tgl_po'        =>  $request->tgl_po,
            'dealer_po'     =>  $request->dealer_po,
            'del'           =>  1,
        ]);

        if($record){
            return redirect()->route('super_admin.po-harian.show', $request->id_tiket_po)->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('super_admin.po-harian.show', $request->id_tiket_po)->with(['error' => 'Data Gagal Ditambah!']);
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
        $record = PO::findOrFail($id)->update([
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
