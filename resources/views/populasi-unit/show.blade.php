@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Detail Populasi Unit - {{$data[0]->nom_unit}}
        </h2>
    </div>
    <hr class="mb-5">

    <!-- Image -->
    <h3 class="font-medium">
        Data Unit
    </h3>
    <hr class="mb-5">
    <div class="grid grid-cols-4 gap-5 mb-5 bg-white rounded-lg shadow-md p-5">
        <img src="https://products.unitedtractors.com/wp-content/uploads/2021/03/lifting-capacity.png" alt="Unit Image" class="rounded-lg w-full">
        <img src="https://products.unitedtractors.com/wp-content/uploads/2021/03/boom-arm-2.png" alt="Unit Image" class="rounded-lg w-full">
        <img src="https://products.unitedtractors.com/wp-content/uploads/2021/03/exterior.png" alt="Unit Image" class="rounded-lg w-full">
        <img src="https://products.unitedtractors.com/wp-content/uploads/2021/03/interior-6.png" alt="Unit Image" class="rounded-lg w-full">
    </div>


    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="flex justify-between items-center">
            <h3 class="font-medium">
                Data Unit
            </h3>

            <div>
                <a href="https://drive.google.com/file/d/1DWyJjaSfIWxXk8GwVe-zmsnpqkG3fsYq/view?usp=sharing" class="mr-3 btn btn-primary mb-2"> 
                    <i data-lucide="activity" class="w-5 h-5 mr-2"></i> OMM 
                </a> 
                <?php 
                    $id = \DB::table('plant_status_bd')->select('id')->where('nom_unit', '=', $data[0]->nom_unit)->get() !== null ?  \DB::table('plant_status_bd')->select('id')->where('nom_unit', '=', $data[0]->nom_unit)->get() : "NONE";
                ?>
                @if (! $id)
                    <a class="btn btn-warning mr-1 mb-2" href="{{route('super_admin.bd-harian-detail.index', $id[0]->id)}}" > 
                        <i data-lucide="hard-drive" class="w-5 h-5 mr-2"></i> BD 
                    </a>
                @endif
            </div>
        </div>
        <hr class="mb-5">

        
        <div class="w-full overflow-x-auto">
            <table class="w-full table table-striped text-xs">
                <tbody>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Code Unit</th>
                        <td>{{$data[0]->nom_unit}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Model</th>
                        <td>{{$data[0]->model}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Type Unit</th>
                        <td>{{$data[0]->type_unit}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Serial Number</th>
                        <td>{{$data[0]->sn}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Engine brand</th>
                        <td>{{$data[0]->engine_brand}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Engine Model</th>
                        <td>{{$data[0]->engine_model}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Engine Serial Number</th>
                        <td>{{$data[0]->engine_sn}}</td>
                    </tr>

                    <tr class="bg-white text-center">
                        <th class="w-10 border">Generator Brand</th>
                        <td>{{$data[0]->generator_brand}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Generator Model</th>
                        <td>{{$data[0]->generator_model}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Generator Serial Number</th>
                        <td>{{$data[0]->generator_sn}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Pump Merk</th>
                        <td>{{$data[0]->pump_merk}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Pump Model</th>
                        <td>{{$data[0]->pump_model}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Pump Serial Number</th>
                        <td>{{$data[0]->pump_sn}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Compressor Brand</th>
                        <td>{{$data[0]->comp_merk}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Compressor Serial Number</th>
                        <td>{{$data[0]->comp_sn}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Kapasitas</th>
                        <td>{{$data[0]->kapasitas}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Horse Power</th>
                        <td>{{$data[0]->HP}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Delivery Order</th>
                        <td>{{$data[0]->DO}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Tinggi/Height</th>
                        <td>{{$data[0]->height}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Lebar/Width</th>
                        <td>{{$data[0]->width}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Panjang/Length</th>
                        <td>{{$data[0]->length}}</td>
                    </tr>
                    <tr class="bg-white text-center">
                        <th class="w-10 border">Fuel (L)</th>
                        <td>{{$data[0]->fuel}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- BEGIN: Super Large Modal Content -->
<div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-5">
            <div class="modal-header">
                <h2 class="font-bold mb-2 text-xl">Data Unit</h2>

            </div>
            <div class="modal-body">

                <div class="overflow-y-auto max-h-[30rem]">
                    <div class="w-full overflow-y-auto sm:max-h-[20rem] mt-3 mb-3">
                        <div class="grid grid-cols-1 gap-5">
                        </div>
                        <div id="imageUnit" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        </div>

                        <table id='tableUnit' class="table table-striped sm:mt-2 table-auto">
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection