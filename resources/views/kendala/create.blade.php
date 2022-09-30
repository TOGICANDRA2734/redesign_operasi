@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Laporan Kendala  - {{App\Models\Site::select('namasite')->where('kodesite', Auth::user()->kodesite)->pluck('namasite')->first()}}
        </h2>
        <div class="dropdown">
            <button class="dropdown-toggle btn btn-primary shadow-md mr-2" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center "> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#input2" class="dropdown-item">Import Excel</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr class="mb-10">



    <!-- Input Form -->
    <div class="intro-y">
        <div class="grid grid-cols-1 gap-3">
            <!-- Start Form -->
            <form action="{{route('kendala.store')}}" method="POST" id="storeDok" class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg  dark:bg-gray-800">
                @csrf
                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Tanggal <span class="text-xs text-gray-500">(Bulan-Hari-Tahun)</span>
                        </span>
                        <input value="{{$waktu}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl" id="tgl" >
                        @error('tgl')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">Site</span>
                        <select data-placeholder="Pilih site" name="kodesite" class="tom-select w-full @error('kodesite') border-danger @enderror">
                            <option value="" selected disabled>Pilih Site</option>
                            @foreach($site as $st)
                            <option value="{{$st->kodesite}}">{{$st->namasite}}</option>
                            @endforeach
                        </select> 
                        @error('kodesite')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>
                
                <div class="col-span-2">
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">Nom Unit</span>
                        <select data-placeholder="Pilih unit" name="unit" class="tom-select w-full @error('unit') border-danger @enderror">
                            <option value="" selected disabled>Pilih Unit</option>
                            @foreach($unit as $ut)
                                <option value="{{$ut->nom_unit}}">{{$ut->nom_unit}}</option>
                            @endforeach
                        </select> 
                        @error('unit')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Awal
                        </span>
                        <!-- <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="awal" id="awal"> -->
                        <div class="input-group">
                            <div id="input-group-email" class="input-group-text">Jam</div> 
                            <input class="form-control" type="text" name="awal" id="awal">
                        </div>
                        @error('awal')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Akhir
                        </span>
                        <!-- <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="akhir" id="akhir"> -->
                        <div class="input-group">
                            <div id="input-group-email" class="input-group-text">Jam</div> 
                            <input class="form-control" type="text" name="akhir" id="akhir">
                        </div>
                        @error('akhir')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Shift
                        </span>
                        <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="shift" id="shift">
                            <option disabled selected value="">Pilih</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                        @error('shift')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Keterangan
                        </span>
            
                        <select data-placeholder="Pilih Keterangan" name="ket" class="tom-select w-full @error('ket') border-danger @enderror">
                            <option value="" selected disabled>Pilih Site</option>
                            @foreach($kendala_code as $st)
                            <option value="{{$st->kode}}">{{$st->kode}} - {{$st->status}}</option>
                            @endforeach
                        </select> 
                        @error('ket')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <button class="col-span-2 btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
    </div>
    <!-- end Overburden Overview -->

    
    <!-- BEGIN: Modal Content -->
    <div id="input2" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Import Excel Productivity Coal</h2>
                    <form action="{{route('kendala.import')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                </div> 
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12"> 
                        <label for="modal-form-4" class="form-label">Data Excel (XLS)</label> 
                        <input id="modal-form-4" type="file" class="form-control" name="excel">
                        @error('excel')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </div>
                </div> 
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer flex justify-between items-center"> 
                    <div>
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batalkan</button> 
                        <button type="submit" class="btn btn-primary w-20">Kirim</button> 
                    </div>
                </div> <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div> 
    <!-- END: Modal Content -->

</div>
@endsection