@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Laporan Kendala - {{$site[0]->namasite}}
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
                            Tanggal <span class="text-xs text-gray-500">(Month-Day-Year)</span>
                        </span>
                        <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl" id="tgl">
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
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Awal
                        </span>
                        <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="awal" id="awal">
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Akhir
                        </span>
                        <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="akhir" id="akhir">
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
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Keterangan
                        </span>
                        <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="ket" id="ket">
                    </label>
                </div>

                <button class="col-span-2 px-10 py-4 font-medium leading-5 text-white transition-colors duration-150 bg-black border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-800 focus:outline-none focus:shadow-outline-black">
                    Submit
                </button>
            </form>
        </div>
    </div>
    <!-- end Overburden Overview -->
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection