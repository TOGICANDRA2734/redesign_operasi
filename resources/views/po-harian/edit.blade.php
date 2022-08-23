@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Transaksi PO Harian
        </h2>
        
        <div class="grid grid-cols-1 gap-3">
            <!-- Dokumen -->
            <form
                action="{{route('super_admin.po-harian.update', $data->id)}}"
                method="POST"
                id="storeDok"
                class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
                @csrf
                @method('PUT')

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">Unit</span>
                    <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="id_tiket_po" id="id_tiket_po">
                        @foreach($id_tiket_po as $it)
                            <option value="{{$it->id}}" {{old('id', $data->id_tiket_po) == $it->id ? 'selected' : ''}}>{{$it->id}}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Nomor PO
                    </span>
                    <input value="{{old('no_po', $data->no_po)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="no_po" id="no_po">
                </label>


                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">PO</span>
                    <input value="{{old('dok_po', $data->dok_po)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="dok_po" id="dok_po">
                </label>

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Tanggal PO
                    </span>
                    <input value="{{old('tgl_po', $data->tgl_po)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl_po" id="tgl_po">
                </label>

                <label class="block mt-4 text-sm">
                    <span class="font-semibold text-gray-700 dark:text-gray-400">
                        Dealer PO
                    </span>
                    <input value="{{old('dealer_po', $data->dealer_po)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="dealer_po" id="dealer_po">
                </label>

                <button type="submit" class="px-5 py-3 mt-4 col-span-2 font-medium leading-5 text-white transition-colors duration-150 bg-stone-700 border border-transparent rounded-lg active:bg-stone-600 hover:bg-stone-900 focus:outline-none focus:shadow-outline-stone w-full">Submit</button>
            </form>

        </div>
    </div>    
</main>


<script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
@endsection