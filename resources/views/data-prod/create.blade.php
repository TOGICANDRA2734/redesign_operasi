@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="bg-gray-100 flex-1 p-6 md:mt-16 overflow-hidden">
    <!-- Title -->
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Produksi Actual
    </h2>
    <hr class="mb-10">


    <!-- Input Form -->
    <div class="card p-6">
        <div class="grid grid-cols-1 gap-3">
            <!-- Start Form -->
            <form action="{{route('data-prod.store')}}" method="POST" id="storeDok" class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg  dark:bg-gray-800">
                @csrf
                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Tanggal <span class="text-xs text-gray-500">(Month-Day-Year)</span>
                        </span>
                        <input value="{{$tgl}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl" id="tgl">
                    </label>
                    @error('tgl')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                    @enderror
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">Site</span>
                        <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                            <option value="">Pilih</option>
                            @foreach($site as $st)
                            <option value="{{$st->kodesite}}">{{$st->namasite}} - {{$st->lokasi}}</option>
                            @endforeach
                        </select>
                    </label>
                    @error('kodesite')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                    @enderror
                </div>
                
                <div class="col-span-2">
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">Pit</span>
                        <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="pit" id="pit">
                            <option value="">Select</option>
                        </select>
                    </label>
                    @error('pit')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                    @enderror
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Overburden <span class="text-xs text-gray-500">(bcm)</span>
                        </span>
                        <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="number" name="ob" id="ob">
                    </label>
                    @error('ob')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                    @enderror
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Coal <span class="text-xs text-gray-500">(mt)</span>
                        </span>
                        <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="number" name="coal" id="coal">
                    </label>
                    @error('coal')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Cuaca
                        </span>
                        <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="cuaca" id="cuaca">
                            <option disabled selected value="">Pilih</option>
                            @foreach($cuaca as $cc)
                                <option value="{{$cc->kode_cuaca}}">{{$cc->nama_cuaca}}</option>
                            @endforeach
                        </select>    
                    </label>
                    @error('cuaca')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                    @enderror
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
<script>
    $("#kodesite").change(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        const kodesite = $(this).val();

        $.ajax({
            type: "POST",
            url: "/detail-pit",
            data: {
                kodesite: kodesite,
            },
            success: function(result) {
                $("#pit").empty();
                $("#pit").append(
                    '<option selected disabled value="">Select</option>'
                );

                if (result && result?.status === "success") {
                    result?.data?.map((pit) => {
                        const pits = `<option value='${pit?.ket}'> ${pit?.ket} </option>`;
                        $("#pit").append(pits);
                    });
                }
            },
            error: function(result) {
                console.log("error", result);
            },
        });
    });
</script>
@endsection