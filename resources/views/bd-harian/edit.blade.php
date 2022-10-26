@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')

<!-- Title -->
<div class="intro-y flex flex-col sm:flex-row items-center mt-8 col-span-12">
    <h2 class="text-lg font-medium mr-auto">
        Edit Unit
    </h2>
</div>
<hr class="mb-10 col-span-12">


<!-- Input Form -->
<div class="intro-y col-span-12">
    <div class="grid grid-cols-1 gap-3">
        <!-- Start Form -->
        <form action="{{route('bd-harian.update', $data->id)}}" method="POST" id="storeDok" class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg  dark:bg-gray-800">
            @csrf
            @method('PUT')
            
            
            <div>
                <label class="block mt-1 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">Site</span>
                    <select data-placeholder="Pilih site" name="site" class="w-full @error('site') border-danger @enderror" aria-readonly>
                        @foreach($site as $st)
                            <option value="{{$st->kodesite}}" {{old('kode_bd', $st->kodesite) == $data->kodesite ? 'selected' : 'disabled'}}>{{$st->namasite}} - {{$st->lokasi}}</option>
                        @endforeach
                    </select> 
                    
                </label>
            </div>

            <div>
                <label class="block mt-1 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">Code Unit</span>
                    <select data-placeholder="Pilih Code Unit" name="nom_unit" class="tom-select w-full @error('nom_unit') border-danger @enderror" >
                        @foreach($nom_unit as $nu)
                            <option value="{{$nu->Nom_unit}}" {{old('nom_unit', $data->nom_unit) == $nu->Nom_unit ? 'selected' : 'disabled'}}>{{$nu->Nom_unit}}</option>
                        @endforeach
                    </select> 
                </label>
            </div>
            
            <div>
                <label class="block mt-1 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Tanggal Breakdown <span class="text-xs text-gray-500">(Bulan-Hari-Tahun)</span>
                    </span>
                    <input value="{{old('tgl_bd', $data->tgl_bd)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl_bd" id="tgl_bd">
                    @error('tgl_bd')
                        <div class="text-danger mt-2">{{$message}}</div>
                    @endif
                </label>
            </div>            

            <div>
                <label class="block mt-1 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Rencana RFU <span class="text-xs text-gray-500">(Bulan-Hari-Tahun)</span>
                    </span>
                    <input value="{{old('tgl_rfu', $data->tgl_rfu)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl_rfu" id="tgl_rfu">
                    @error('tgl_rfu')
                        <div class="text-danger mt-2">{{$message}}</div>
                    @endif
                </label>
            </div>            

            <div>
                <label for="crud-form-1" class="form-label">
                    Ket. Rencana RFU
                </label>
                <input value="{{old('ket_tgl_rfu', $data->ket_tgl_rfu)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="ket_tgl_rfu" id="ket_tgl_rfu">
                @error('ket_tgl_rfu')
                    <div class="text-danger mt-2">{{$message}}</div>
                @endif
            </div>

            <div>
                <label for="crud-form-1" class="form-label">
                    Kode BD
                </label>
                <select
                    name="kode_bd"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                >
                    @foreach($kode_bd as $kb)
                        <option value="{{$kb->kode_bd}}" {{old('kode_bd', $kb->kode_bd) == $data->kode_bd ? 'selected' : ''}}>{{$kb->kode_bd}}</option>
                    @endforeach
                </select>

                @error('kode_bd')
                    <div class="text-danger mt-2">{{$message}}</div>
                @endif
            </div>

            <div>
                <label for="crud-form-1" class="form-label">
                    HM
                </label>
                <input value="{{old('hm', $data->hm)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="number" step="0.01" min="0" name="hm" id="hm">
                @error('hm')
                    <div class="text-danger mt-2">{{$message}}</div>
                @endif
            </div>

            <div>
                <label for="crud-form-1" class="form-label">
                    PIC
                </label>
                <input value="{{old('pic', $data->pic)}}"  class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="pic" id="pic">
                @error('PIC')
                    <div class="text-danger mt-2">{{$message}}</div>
                @endif
            </div>

            <div>
                <label for="crud-form-1" class="form-label">
                    Keterangan
                </label>
                <input value="{{old('keterangan', $data->keterangan)}}"  class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="keterangan" id="keterangan">
                @error('keterangan')
                    <div class="text-danger mt-2">{{$message}}</div>
                @endif
            </div>

            <button class="col-span-2 btn btn-primary">
                Submit
            </button>
        </form>
    </div>
</div>
@endsection

