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
                <a href="{{route('hm.edit', $data[0]->id)}}" class="btn px-2 box mr-2">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                </a>
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

        <div class="grid grid-cols-12 gap-5">
            {{-- Data Unit --}}
            <div class="w-full overflow-x-auto col-span-6">
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
            {{-- End Data Unit --}}

            {{-- Data HM Unit --}}
            <div class="w-full overflow-x-auto col-span-6">
                <table class="w-full table table-striped text-xs">
                    <tbody>
                        @foreach ($dataHM as $key => $dt)
                            <tr class="bg-white text-center">
                                <th class="w-28 border">HM {{$key + 1}} <br> ({{$dt->tgl}})</th>
                                <td>{{ number_format($dt->hm) }}</td>
                                <td class="whitespace-nowrap text-center">
                                    <a href="{{ route('hm.edit.data', $dt->id) }}" class="btn btn-warning text-white">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="{{ route('hm.edit.data', $dt->id) }}" class="btn btn-warning text-white">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- End Data HM Unit --}}
        </div>
    </div>
</div>
@endsection