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
                        <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl" id="tgl">
                        @error('tgl')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">Site</span>
                        <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                            <option disabled selected value="">Pilih</option>
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
                        <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="unit" id="unit">
                            <option disabled selected value="">Select</option>
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
                        <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="ket" id="ket">
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
</div>


@endsection