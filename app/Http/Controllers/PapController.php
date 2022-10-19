<?php

namespace App\Http\Controllers;

use App\Models\PapBagian;
use App\Models\Plant_Pap;
use App\Models\Plant_Populasi;
use App\Models\plantPapBagianTesting;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Storage::disk('public')->files('dokumenPlantPap/pdf');
        $d = [];
        foreach($data as $dt){
            foreach(explode('_', basename($dt)) as $word){
                $d[] = $word;
            }
        }

        $x = [];
        $storagePath = "dokumenPlantPap";
        foreach ($data as $key => $dt) {
            $kata = [];
            foreach(explode('_', basename($dt)) as $d){
                $kata[] = $d;
            }

            $model = Plant_Populasi::select('model')->where('nom_unit', $kata[0])->pluck('model');
            $kodeBagian = PapBagian::select('id')->where('model', $model[0])->where('bagian', $kata[1])->pluck('id');
            Storage::disk('public')->copy($dt, $storagePath . '/' . basename($dt));
            Plant_Pap::create([
                'nom_unit' => $kata[0],
                'kode_bagian' => $kodeBagian[0],
                'tgl' => date('Y-m-d', strtotime(substr($d[2], 0,2) . '-' . substr($d[2], 2,4) . '-' . '2022')),
                'file' => basename($dt),
            ]);   
        }

        
        $cariNama = $request->has('cariNama') ? $request->cariNama : ''; 
        $data = DB::table('plant_pap')
        ->select('id','nom_unit')
        ->when($cariNama, function($query, $cariNama){
            $query->where('nom_unit', 'LIKE', '%' . $cariNama . '%');
        })
        ->orderBy('nom_unit')
        ->get();

        $site  = Site::where('status',1)->get();
        if(count($request->all()) > 1){
            $response['data'] = $data;
            return response()->json($response);
        }
        else {
            return view('pap.index', compact('site', 'data'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subquery = "SELECT * FROM plant_populasi WHERE del=0" ;
        $nom_unit = collect(DB::select($subquery));
        $site = Site::where('status',1)->get();
        return view('pap.create', compact('site', 'nom_unit'));
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
            'site' => 'required|string|max:1',
            'nom_unit' => 'required|string|max:10',
            'kompartemen' => 'required|int',
            'file_pap' => 'required|file|mimes:pdf',
        ]);

        $file = $request->file('file_pap');
        $ext = $file->extension();
        $namaFile = Site::select('namasite')->where('kodesite', $request->site)->pluck('namasite')->first() . '_' . Carbon::now()->format('d_m_Y') . '_' . Carbon::now()->format('H_i_s') . '_' . $request->nom_unit . '.' . $ext;
        // $temporaryFile = TemporaryFiles::where('filename', $request->file->getClientOriginalName())->first();
        $file->storeAs('public/dokumenPlantPap', $namaFile);

        $record = Plant_Pap::create([
            'nom_unit' => $request->nom_unit,
            'tgl' => date('Y-m-d', strtotime(Carbon::now())),
            'waktu' => date('h:i:s', strtotime(Carbon::now())),
            'file' => $namaFile,
            'kode_bagian' => $request->kompartemen,
            'kodesite' => $request->site,
            'del' => 0
        ]);

        if($record){
            return redirect()->route('super_admin.pap.index')->with(['success' => 'Data Berhasil Ditambah!']);
        }
        else{
            return redirect()->route('super_admin.pap.create')->with(['error' => 'Data Gagal Ditambah!']);
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
        $dataUnit = Plant_Pap::findOrFail($id);
    
        $subquery = "SELECT bagian, date_format(tgl, '%d-%m-%Y'), a.id, namasite,  date_format(waktu, '%h:%i:%s'), file FROM plant_pap a JOIN site b ON a.kodesite=b.kodesite JOIN plant_pap_bagian c ON a.kode_bagian=c.id WHERE a.del=0 AND nom_unit='".$dataUnit->nom_unit."'" ;
        $data = collect(DB::select($subquery));
        $site = Site::where('status',1)->get();
        return view('pap.show',compact('site', 'data', 'dataUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pap.edit');
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

    public function delete($id)
    {
        
    }

    public function getPapBagian(Request $request)
    {
        if($request->has('nom_unit')){
            $subquery = "SELECT model FROM plant_populasi WHERE del=0 AND nom_unit='".$request->nom_unit."'";
            $type = DB::select(DB::raw($subquery));
            $subquery = "SELECT id, bagian FROM plant_pap_bagian WHERE del=0 AND model LIKE '%".$type[0]->model."%'";
            $type = DB::select(DB::raw($subquery));    
        } else if($request->has('site')) {
            $subquery = "SELECT nom_unit FROM plant_populasi WHERE del=0 AND kodesite='".$request->site."'";
            $type = DB::select(DB::raw($subquery));
        }
        
        return response()->json($type);
    }


    public function testingDropzone()
    {

        return view('pap.testing');
    }

    public function postDropzone(Request $request)
    {
        plantPapBagianTesting::create([
            'nom_unit' => 'CEK',
            'bagian' => 'model',
        ]);


        return 'Ashiap';
    }
}
