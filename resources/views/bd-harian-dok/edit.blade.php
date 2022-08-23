@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Transaksi Detail Baru
        </h2>
        
        <div class="grid grid-cols-1 gap-3">
            <!-- Dokumen -->
            <form
                action="{{route('super_admin.bd-harian-dok.update', $data->id)}}"
                method="POST"
                id="storeDok"
                class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
                @csrf
                @method('PUT')
                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">Unit</span>
                    <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="id_tiket" id="id_tiket">
                        @foreach($dok_tiket as $it)
                            <option value="{{$it->id}}" {{old('id_tiket', $data->id_tiket) == $it->id ? 'selected' : ''}}>{{$it->id}} - {{$it->nom_unit}}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">Dokumen</span>
                    <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="dok_type" id="dok_type">
                        @foreach($dok_type as $nu)
                            <option value="{{$nu->dok_type}}" {{old('dok_type', $data->dok_type) == $nu->dok_type ? 'selected' : ''}}>{{$nu->dok_type}}</option>
                        @endforeach
                    </select>
                </label>
                

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        No
                    </span>
                    <input value="{{old('dok_no', $data->dok_no)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="dok_no" id="dok_no">
                </label>

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Tanggal
                    </span>
                    <input value="{{old('dok_tgl', $data->dok_tgl)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="dok_tgl" id="dok_tgl">
                </label>

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Deskripsi
                    </span>
                    <input value="uraian" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="uraian" id="uraian">
                </label>

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Keterangan
                    </span>
                    <input value="{{old('keterangan', $data->keterangan)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="keterangan" id="keterangan">
                </label>

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Uraian Breakdown
                    </span>
                    <input value="{{old('uraian_bd', $data->uraian_bd)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="uraian_bd" id="uraian_bd">
                </label>

                <button type="submit" class="px-5 py-3 mt-4 col-span-2 font-medium leading-5 text-white transition-colors duration-150 bg-stone-700 border border-transparent rounded-lg active:bg-stone-600 hover:bg-stone-900 focus:outline-none focus:shadow-outline-stone w-full">Submit</button>
            </form>

        </div>
    </div>    
</main>


<script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
@endsection