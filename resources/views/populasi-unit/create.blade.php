@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="flex justify-between items-center mt-8 ">
    <h2 class="text-lg font-medium ">
        Transaksi Populasi Unit
    </h2>
</div>
<hr class="mb-10">

<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12">
        <!-- BEGIN: Form Layout -->
        <form action="{{route("populasi-unit.store")}}" method="POST" class="intro-y box p-5 grid md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label for="crud-form-1" class="form-label">Code Unit</label>
                <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Masukkan Code Unit" name="nom_unit">
                @error('nom_unit')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="">
                <label for="crud-form-2" class="form-label">Model</label>
                <select data-placeholder="Pilih Model" class="tom-select w-full" id="crud-form-2" name="model">
                    <option value="" selected disabled>-</option>
                    <!-- Pick Every Distinct Model in plant populasi -->
                    @foreach ($model as $dt)
                        <option value="{{$dt->model}}" class="uppercase">{{$dt->model}}</option>                    
                    @endforeach
                </select>
                @error('model')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-3" class="form-label">Type Unit</label>
                <select data-placeholder="Pilih Type Unit" class="tom-select w-full" id="crud-form-3" name="type_unit">
                    <!-- Pick Every disticnt type unit in plant populasi -->
                    <option value="" selected disabled>-</option>
                    @foreach ($type_unit as $dt)
                        <option value="{{$dt->type_unit}}" class="uppercase">{{$dt->type_unit}}</option>                    
                    @endforeach
                </select>
                @error('type_unit')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
            
            <div class="mt-3">
                <label for="crud-form-4" class="form-label">Serial Number</label>
                <input id="crud-form-4" type="text" class="form-control w-full" placeholder="Masukkan Serial Number" name="sn">
                @error('sn')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
            
            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Engine Brand</label>
                <select data-placeholder="Pilih Engine Brand" class="tom-select w-full" id="crud-form-5" name="engine_brand">
                    <option value="" selected disabled>-</option>
                    @foreach ($engine_brand as $dt)
                        <option value="{{$dt->engine_brand}}" class="uppercase">{{$dt->engine_brand}}</option>                    
                    @endforeach
                </select>
                @error('engine_brand')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
            
            <div class="mt-3">
                <label for="crud-form-6" class="form-label">Engine Model</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Engine Model" name="engine_model">
                @error('engine_model')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-6" class="form-label">Engine Serial Number</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Engine Serial Number" name="engine_sn">
                @error('engine_sn')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Generator Brand</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Generator Brand" name="generator_brand">
                @error('generator_brand')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
            
            <div class="mt-3">
                <label for="crud-form-6" class="form-label">Generator Model</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Generator Model" name="generator_model">
                @error('generator_model')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Generator Serial Number</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Generator Serial Number" name="generator_sn">
                @error('generator_sn')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Pump Brand</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Pump Brand" name="pump_merk">
                @error('pump_merk')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
            
            <div class="mt-3">
                <label for="crud-form-6" class="form-label">Pump Model</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Pump Model" name="pump_model">
                @error('pump_model')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Pump Serial Number</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Pump Serial Number" name="pump_sn">
                @error('pump_sn')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Compressor Brand</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Compressor Brand" name="comp_merk">
                @error('comp_merk')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
            
            <div class="mt-3">
                <label for="crud-form-6" class="form-label">Compressor Model</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Compressor Model" name="comp_model">
                @error('comp_model')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Compressor Serial Number</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Compressor Serial Number" name="comp_sn">
                @error('comp_sn')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
            
            <div class="mt-3">
                <label for="crud-form-6" class="form-label">Kapasitas</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Kapasitas" name="kapasitas">
                @error('kapasitas')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-7" class="form-label">Horse Power (HP)</label>
                <input id="crud-form-7" type="text" class="form-control w-full" placeholder="Masukkan HP" name="HP">
                @error('HP')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-8" class="form-label">Delivery Order (DO)</label>
                @php
                    $waktu = \Carbon\Carbon::now()->format('Y-m-d');
                @endphp
                <input value="{{$waktu}}" id="crud-form-8" type="date" class="form-control w-full" placeholder="Masukkan DO" name="do">
                @error('do')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-9" class="form-label">PIC 1</label>
                <input id="crud-form-9" type="text" class="form-control w-full" placeholder="Masukkan PIC 1" name="pic_1">
                @error('pic_1')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
            
            <div class="mt-3">
                <label for="crud-form-9" class="form-label">PIC 2</label>
                <input id="crud-form-9" type="text" class="form-control w-full" placeholder="Masukkan PIC 2" name="pic_2">
                @error('pic_2')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
            
            <div class="mt-3">
                <label for="crud-form-11" class="form-label">Height</label>
                <div class="input-group">
                    <input id="crud-form-11" type="text" class="form-control" placeholder="Masukkan Tinggi Unit" aria-describedby="input-group-1" name="height">
                    <div id="input-group-1" class="input-group-text">Meter</div>
                </div>
                @error('height')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-12" class="form-label">Width</label>
                <div class="input-group">
                    <input id="crud-form-12" type="text" class="form-control" placeholder="Width" aria-describedby="input-group-2" name="width">
                    <div id="input-group-2" class="input-group-text">Meter</div>
                </div>
                @error('width')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-13" class="form-label">Length</label>
                <div class="input-group">
                    <input id="crud-form-13" type="text" class="form-control" placeholder="Length" aria-describedby="input-group-3" name="length">
                    <div id="input-group-3" class="input-group-text">Meter</div>
                </div>
                @error('length')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-14" class="form-label">Fuel</label>
                <div class="input-group">
                    <input id="crud-form-14" type="text" class="form-control" placeholder="Fuel" aria-describedby="input-group-4" name="fuel">
                    <div id="input-group-4" class="input-group-text">Liter</div>
                </div>
                @error('fuel')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Status Bagian</label>
                <select data-placeholder="Pilih Status Bagian" class="tom-select w-full" id="crud-form-5" name="status_bagian">
                    <option value="" selected disabled>-</option>
                    @foreach ($status_bagian as $dt)
                        <option value="{{$dt->id}}" class="uppercase">{{$dt->status}}</option>                    
                    @endforeach
                </select>
                @error('status_bagian')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Status Kepemilikan</label>
                <select data-placeholder="Pilih Status Kepemilikan" class=" w-full" id="crud-form-5" name="status_kepemilikan">
                    <option value="1">Milik RCI</option>
                    <option value="0">SUBCONT</option>
                </select>
                @error('status_kepemilikan')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Site</label>
                <select data-placeholder="Pilih Site" class="tom-select w-full" id="crud-form-5" name="kodesite">
                    @foreach ($site as $dt)
                        <option value="{{$dt->kodesite}}" class="uppercase">{{$dt->namasite}}</option>                    
                    @endforeach
                </select>
                @error('kodesite')
                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>
        <!-- END: Form Layout -->
    </div>
    <div class="ml-auto mt-5 flex intro-y">
        <button type="button" class="btn btn-outline-secondary w-24 mr-1 bg-white">Cancel</button>
        <button type="submit" class="btn btn-primary w-24">Save</button>
    </div>
</form>
</div>
@endsection