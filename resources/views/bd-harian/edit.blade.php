@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Edit Unit
        </h2>

        <form
            action="{{route('super_admin.bd-harian.update', $data->id)}}"
            method="POST"
            id="storeUtama"
            class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg shadow-md dark:bg-gray-800"
        >
            @csrf
            @method('PUT')
            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Nomor Unit</span>
                <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="nom_unit" id="nom_unit">
                    @foreach($nom_unit as $nu)
                        <option value="{{$nu->Nom_unit}}" {{old('nom_unit', $data->nom_unit) == $nu->Nom_unit ? 'selected' : ''}}>{{$nu->Nom_unit}}</option>
                    @endforeach
                </select>
            </label>
            

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Tanggal Breakdown
                </span>
                <input value="{{old('tgl_bd', $data->tgl_bd)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl_bd" id="tgl_bd">
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Rencana RFU
                </span>
                <input value="{{old('tgl_rfu', $data->tgl_rfu)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl_rfu" id="tgl_rfu">
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Ket. Rencana RFU
                </span>
                <input value="{{old('ket_tgl_rfu', $data->ket_tgl_rfu)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="ket_tgl_rfu" id="ket_tgl_rfu">
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Status BD
                </span>
                <select
                    name="kode_bd"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                >
                    @foreach($kode_bd as $kb)
                        <option value="{{$kb->kode_bd}}" {{old('kode_bd', $kb->kode_bd) == $data->kode_bd ? 'selected' : ''}}>{{$kb->kode_bd}}</option>
                    @endforeach
                </select>
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    HM
                </span>
                <input value="{{old('hm', $data->hm)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="hm" id="hm">
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    PIC
                </span>
                <input value="{{old('pic', $data->pic)}}"  class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="pic" id="pic">
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Site
                </span>

                <select
                    name="site"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                >
                    @foreach($site as $st)
                        <option value="{{$st->kodesite}}" {{old('kode_bd', $st->kodesite) == $data->kodesite ? 'selected' : ''}}>{{$st->namasite}} - {{$st->lokasi}}</option>
                    @endforeach
                </select>
            </label>


            <button type="submit" class="px-5 py-3 mt-4 col-span-2 font-medium leading-5 text-white transition-colors duration-150 bg-stone-700 border border-transparent rounded-lg active:bg-stone-600 hover:bg-stone-900 focus:outline-none focus:shadow-outline-stone w-full">Submit</button>
        </form>
        
    </div>    
</main>


@endsection