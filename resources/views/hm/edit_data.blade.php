@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<!-- Title -->
<div class="intro-y flex flex-col sm:flex-row items-center mt-8 col-span-12">
    <h2 class="text-lg font-medium mr-auto">
        Edit Transaksi HM 
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
<hr class="mb-10 col-span-12">


<!-- Input Form -->
<div class="intro-y col-span-12">
    <div class="grid grid-cols-1 gap-3">
        <!-- Start Form -->
        <form action="{{route('hm.update.data', $id)}}" method="POST" id="storeDok" class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg  dark:bg-gray-800">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block mt-1 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">Site</span>
                    <select data-placeholder="Pilih site" name="kodesite" class="w-full @error('kodesite') border-danger @enderror" aria-readonly>
                        @foreach ($site as $dt)
                            <option value="{{$dt->kodesite}}" {{old('kodesite', $dataEdit->kodesite) == $dt->kodesite ? 'selected' : 'disabled'}}>{{$dt->namasite}} - {{$dt->lokasi}}</option>                            
                        @endforeach
                    </select> 
                </label>
            </div>

            <div>
                <label class="block mt-1 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">Code Unit</span>
                    <select data-placeholder="Pilih Code Unit" name="nom_unit" class="tom-select w-full @error('nom_unit') border-danger @enderror" >
                        @foreach ($nom_unit as $dt)
                            <option value="{{$dt->nom_unit}}" {{old('nom_unit', $dataEdit->nom_unit) == $dt->nom_unit ? 'selected' : 'disabled'}}>{{$dt->nom_unit}}</option>                            
                        @endforeach
                    </select> 
                </label>
            </div>
            

            
            <div>
                <label class="block mt-1 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Tanggal <span class="text-xs text-gray-500">(Bulan-Hari-Tahun)</span>
                    </span>
                    <input value="{{old('tgl', $dataEdit->tgl)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl" id="tgl" >
                    @error('tgl')
                        <div class="text-danger mt-2">{{$message}}</div>
                    @endif
                </label>
            </div>            

            <div>
                <label for="crud-form-1" class="form-label">
                    HM
                </label>
                <input value="{{old('hm', $dataEdit->hm)}}" id="crud-form-1" class="form-control w-full" type="number" step="0.01" min="0" name="hm" placeholder="Input HM">
                @error('hm')
                    <div class="text-danger mt-2">{{$message}}</div>
                @endif
            </div>

            <div>
                <label for="crud-form-1" class="form-label">
                    KM
                </label>
                <input value="{{old('km', $dataEdit->km)}}" id="crud-form-1" class="form-control w-full" type="number" step="0.01" min="0" name="km" id="km" placeholder="Input KM">
                @error('km')
                    <div class="text-danger mt-2">{{$message}}</div>
                @endif
            </div>
            
            <button class="col-span-2 btn btn-primary">
                Submit
            </button>
        </form>
    </div>
</div>
<!-- end Overburden Overview -->

<!-- Start Kendala -->
<div class="col-span-12 w-full mb-8 overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
        <table class="w-full table table-striped">
            <thead class="table-dark">
                <tr class="">
                    <th rowspan="2" class="whitespace-nowrap text-center">#</th>
                    <th rowspan="2" class="whitespace-nowrap text-center">Code Unit</th>
                    <th rowspan="2" class="whitespace-nowrap text-center">Tanggal</th>
                    <th rowspan="2" class="whitespace-nowrap text-center">HM</th>
                    <th rowspan="2" class="whitespace-nowrap text-center">KM</th>
                    <th rowspan="2" class="whitespace-nowrap text-center">Site</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach($data as $key => $dt)
                <tr class="text-center bg-white">
                    <td class="">
                        {{$key + 1}}
                    </td>
                    <td class="">
                        {{$dt->nom_unit}}
                    </td>
                    <td class="">
                        {{$dt->tgl}}
                    </td>
                    <td class="">
                        {{number_format($dt->hm)}}
                    </td>
                    <td class="">
                        {{number_format($dt->km)}}
                    </td>
                    <td class="">
                        {{\App\Models\Site::select('namasite')->where('kodesite', $dt->kodesite)->pluck('namasite')[0]}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- End Kendala -->
@endsection