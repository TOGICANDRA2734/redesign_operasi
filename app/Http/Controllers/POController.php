<?php

namespace App\Http\Controllers;

use App\Models\Plant_bd;
use App\Models\Plant_bd_dok;
use App\Models\PO;
use App\Models\unitPoReq;
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
        $subquery = "SELECT a.nodokstream, a.tgdok, a.item, a.pn, a.descript, a.qtyrs, c.ref_no, po_date, c.name, 'c.pn', 'c.qtypo', c.voucher_doc, c.voucher_no, c.voucher_date, 'c.qtymrs'
        -- a.tgdok, a.item, a.cat, a.pn, a.status, a.descript, a.mechanic, b.pr_type, b.pr_no, b.sq_no, b.pr_date, b.vend_code, b.item_code, b.item_qty, b.pr_desc4, b.po_date, b.grr_date, c.voucher_doc, c.voucher_no, c.sq_no, c.voucher_date, c.code, c.name, c.item_code, c.form_code, d.item_name, DATE_FORMAT(b.po_date, '%d-%m-%Y') tgl, c.name, DATEDIFF(IFNULL(voucher_date,0), IFNULL(a.tgdok,0)) estimasi, date_format(IF(voucher_date is null, DATE_ADD(tgdok, INTERVAL DATEDIFF(IFNULL(voucher_date,0), IFNULL(a.tgdok,0)) DAY), voucher_date), '%d-%m-%Y') est_date
        FROM unit_rssp a
        JOIN (SELECT * FROM unit_po_req WHERE ref_no='".$id."' ) b
        ON a.nodokstream=b.ref_no
        LEFT JOIN (SELECT * FROM unit_in_trans WHERE pr_no='".$id."') c
        ON b.pr_no=c.pr_no
        JOIN unit_t_item d
        ON b.item_code=d.item_code
        WHERE nodokstream='".$id."'
        GROUP BY c.item_code";
        $data = DB::select(DB::raw($subquery));
        return view('po-harian.show', compact('data'));
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
