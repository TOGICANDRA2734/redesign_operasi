@extends('../layout/' . $layout)

@section('subhead')
<title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Edit Produksi Actual
        </h2>
    </div>
    <hr class="mb-10">

    <!-- Input Form -->
    <div class="intro-y">
        <div class="grid grid-cols-1 gap-3">

            <!-- Start Form -->
            <form action="{{route('admin.update_data.index', $data->id)}}" method="POST" id="storeDok" class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg  dark:bg-gray-800">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Tanggal <span class="text-xs text-gray-500">(Month-Day-Year)</span>
                        </span>
                        <input value="{{old('tgl', $data->tgl)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" disabled>
                        <input value="{{old('tgl', $data->tgl)}}" type="hidden" name="tgl" id="tgl">
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
                            <option value="{{$st->kodesite}}" {{old('kodesite', $data->kodesite) == $st->kodesite ? 'selected' : ''}}>{{$st->namasite}} - {{$st->lokasi}}</option>
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
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Cuaca
                        </span>
                        <select class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="cuaca" id="cuaca">
                            <option disabled selected value="">Pilih</option>
                            @foreach($cuaca as $cc)
                            <option class="capitalize" value="{{$cc->kode_cuaca}}" {{old('cuaca', $data->cuaca) == $cc->kode_cuaca ? 'selected' : ''}}>{{$cc->nama_cuaca}}</option>
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

                @foreach($dataProd as $key => $dp)
                <!-- Start PIT -->
                <div class="col-span-2">
                    <label class="block mt-1 text-lg uppercase">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">Pit {{$key + 1}}: {{$dp->pit}}</span>
                        <input type="hidden" name="pit_{{$key}}" value="{{$dp->pit}}">
                        <hr class="pt-3">
                    </label>
                </div>
                <!-- End Pit -->

                <!-- Shift 1 -->
                <div class="col-span-2 grid grid-cols-2 gap-5">
                    <div class="grid grid-cols-2 gap-5">
                        <span class="font-semibold text-gray-700 dark:text-gray-400 block col-span-2">
                            Shift 1
                        </span>
                        <div>
                            <label class="block mt-1 text-sm">
                                <span class="font-semibold text-gray-700 dark:text-gray-400">
                                    Overburden <span class="text-xs text-gray-500">(bcm)</span>
                                </span>
                                <div class="input-group mt-2">
                                    <input value="{{old('ob', $dp->ob_1)}}" type="number" name="ob_1_{{$key}}" id="ob_1_{{$key}}" class="form-control" placeholder="Price" aria-label="Price" aria-describedby="input-group-price">
                                    <div id="input-group-price" class="input-group-text">bcm</div>
                                </div>
                            </label>
                            @error('ob_1')
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
                                <div class="input-group mt-2">
                                    <input value="{{old('coal', $dp->coal_1)}}" type="number" name="coal_1_{{$key}}" id="coal_1_{{$key}}" class="form-control" placeholder="Price" aria-label="Price" aria-describedby="input-group-price">
                                    <div id="input-group-price" class="input-group-text">mt</div>
                                </div>
                            </label>
                            @error('coal_1')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <span class="font-semibold text-gray-700 dark:text-gray-400 block col-span-2">
                            Shift 2
                        </span>
                        <div>
                            <label class="block mt-1 text-sm">
                                <span class="font-semibold text-gray-700 dark:text-gray-400">
                                    Overburden <span class="text-xs text-gray-500">(bcm)</span>
                                </span>
                                <!-- <input value="{{old('ob', $dp->ob_2)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="number" name="ob_2_{{$key}}" id="ob_2_{{$key}}"> -->
                                <div class="input-group mt-2">
                                    <input value="{{old('ob', $dp->ob_2)}}" type="number" name="ob_2_{{$key}}" id="ob_2_{{$key}}" class="form-control" placeholder="Price" aria-label="Price" aria-describedby="input-group-price">
                                    <div id="input-group-price" class="input-group-text">bcm</div>
                                </div>
                            </label>
                            @error('ob_2')
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
                                <!-- <input value="{{old('coal', $dp->coal_2)}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="number" name="coal_2_{{$key}}" id="coal_2_{{$key}}"> -->
                                <div class="input-group mt-2">
                                    <input value="{{old('coal', $dp->coal_2)}}" type="number" name="coal_2_{{$key}}" id="coal_2_{{$key}}" class="form-control" placeholder="Price" aria-label="Price" aria-describedby="input-group-price">
                                    <div id="input-group-price" class="input-group-text">mt</div>
                                </div>
                            </label>
                            @error('coal_2')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- End Shift 1 -->
                @endforeach

                <button class="col-span-2 btn btn-primary">
                    Submit
                </button>
            </form>
            <!-- End Form -->
        </div>
    </div>
    <!-- end Overburden Overview -->
</div>
@endsection