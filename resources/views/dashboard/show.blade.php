@extends('../layout/' . $layout)

@section('subhead')
<title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<!-- File baru -->
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Detail Site {{$data[0]->namasite}}</h2>
                    <a href="" class="ml-auto flex items-center text-primary">
                    </a>
                </div>
            </div>
            <!-- END: General Report -->
            <!-- BEGIN: Overbuden Report -->
            <div class="col-span-12 lg:col-span-6 mt-1">
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex">
                            <div>
                                <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">Overburden</div>
                                <div class="mt-0.5 text-slate-500">BCM</div>
                            </div>
                        </div>
                        <div class="dropdown md:ml-auto mt-5 md:mt-0">
                            <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown">
                                Filter by Category <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                            </button>
                            <div class="dropdown-menu w-40">
                                <ul class="dropdown-content overflow-y-auto h-32">
                                    <li><a href="" class="dropdown-item">PC & Laptop</a></li>
                                    <li><a href="" class="dropdown-item">Smartphone</a></li>
                                    <li><a href="" class="dropdown-item">Electronic</a></li>
                                    <li><a href="" class="dropdown-item">Photography</a></li>
                                    <li><a href="" class="dropdown-item">Sport</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <canvas id="overburden" class="mt-6"></canvas>
                    </div>
                </div>
            </div>
            <!-- END: Overburden Report -->
            <!-- BEGIN: Coal Report -->
            <div class="col-span-12 lg:col-span-6 mt-1">

                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex">
                            <div>
                                <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">Coal</div>
                                <div class="mt-0.5 text-slate-500">MT</div>
                            </div>
                        </div>
                        <div class="dropdown md:ml-auto mt-5 md:mt-0">
                            <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown">
                                Filter by Category <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                            </button>
                            <div class="dropdown-menu w-40">
                                <ul class="dropdown-content overflow-y-auto h-32">
                                    <li><a href="" class="dropdown-item">PC & Laptop</a></li>
                                    <li><a href="" class="dropdown-item">Smartphone</a></li>
                                    <li><a href="" class="dropdown-item">Electronic</a></li>
                                    <li><a href="" class="dropdown-item">Photography</a></li>
                                    <li><a href="" class="dropdown-item">Sport</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <canvas id="coal" class="mt-6"></canvas>
                    </div>
                </div>
            </div>
            <!-- END: Coal Report -->
            <!-- BEGIN: Production Report -->
            <div class="col-span-6 mt-4 intro-y">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Produksi</h2>
                    <div class="dropdown md:ml-auto mt-5 md:mt-0 bg-white">
                        <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown">
                            Filter by Category <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content overflow-y-auto h-32">
                                <li><a href="" class="dropdown-item">PC & Laptop</a></li>
                                <li><a href="" class="dropdown-item">Smartphone</a></li>
                                <li><a href="" class="dropdown-item">Electronic</a></li>
                                <li><a href="" class="dropdown-item">Photography</a></li>
                                <li><a href="" class="dropdown-item">Sport</a></li>
                            </ul>
                        </div>
                    </div>
                </div>



                <div class="overflow-x-auto mt-4">
                    <table class="table rounded-lg">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2" class="text-center whitespace-nowrap">#</th>
                                <th rowspan="2" class="text-center whitespace-nowrap">Tanggal</th>
                                <th colspan="2" class="text-center whitespace-nowrap">Overburden</th>
                                <th colspan="2" class="text-center whitespace-nowrap">Coal</th>
                            </tr>
                            <tr>
                                <th class="text-center whitespace-nowrap">Plan</th>
                                <th class="text-center whitespace-nowrap">Act</th>
                                <th class="text-center whitespace-nowrap">Plan</th>
                                <th class="text-center whitespace-nowrap">Act</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($data as $key => $dt)
                            <tr class="text-center">
                                <td>
                                    {{$key+1}}
                                </td>
                                <td>
                                    {{date('d-m-Y', strtotime($dt->tgl))}}
                                </td>
                                <td>
                                    {{$dt->ob_plan}}
                                </td>
                                <td>
                                    {{$dt->ob_act}}
                                </td>
                                <td>
                                    {{$dt->coal_plan}}
                                </td>
                                <td>
                                    {{$dt->coal_act}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Production Report -->
            <!-- BEGIN: Kendala Report -->
            <div class="col-span-6 mt-4 intro-y">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Kendala</h2>
                    <div class="dropdown md:ml-auto mt-5 md:mt-0 bg-white">
                        <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown">
                            Filter by Category <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content overflow-y-auto h-32">
                                <li><a href="" class="dropdown-item">PC & Laptop</a></li>
                                <li><a href="" class="dropdown-item">Smartphone</a></li>
                                <li><a href="" class="dropdown-item">Electronic</a></li>
                                <li><a href="" class="dropdown-item">Photography</a></li>
                                <li><a href="" class="dropdown-item">Sport</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto mt-4">
                    <table class="table rounded-lg">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2" class="text-center whitespace-nowrap">#</th>
                                <th rowspan="2" class="text-center whitespace-nowrap">Tanggal</th>
                                <th rowspan="2" class="text-center whitespace-nowrap">Nom Unit</th>
                                <th rowspan="2" class="text-center whitespace-nowrap">Shift</th>
                                <th colspan="2" class="text-center whitespace-nowrap">Waktu</th>
                                <th rowspan="2" class="text-center whitespace-nowrap">Keterangan</th>
                            </tr>
                            <tr>
                                <th class="text-center whitespace-nowrap">Awal</th>
                                <th class="text-center whitespace-nowrap">Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($kendala as $dt)
                            <tr class="text-center">
                                <td>
                                    {{1}}
                                </td>
                                <td>
                                    {{date('d-m-Y', strtotime($dt->tgl))}}
                                </td>
                                <td>
                                    {{$dt->unit}}
                                </td>
                                <td>
                                    {{$dt->shift}}
                                </td>
                                <td>
                                    {{$dt->awal}}
                                </td>
                                <td>
                                    {{$dt->akhir}}
                                </td>
                                <td>
                                    {{$dt->ket}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Kendala Report -->
        </div>
    </div>
</div>




<!-- File Lama -->



<div class="bg-gray-100 flex-1 p-6 md:mt-16 overflow-hidden">
    
    <!-- Filter -->
    <form action="#" method="GET" class="mt-3 flex justify-end items-center">
        <select class="p-1 border border-gray-100 rounded-md w-full mr-2" name="pit" id="pit">
            <option value="" selected>Semua Pit</option>
            @foreach($pit as $pt)
            <option value="{{$pt->ket}}">{{$pt->ket}}</option>
            @endforeach
        </select>
        <button class="px-3 py-1 text-sm font-medium leading-5 bg-black text-white transition-colors duration-150 border border-transparent rounded-md active:bg-stone-600 hover:bg-stone-700 focus:outline-none focus:shadow-outline-purple">
            Refresh
        </button>
    </form>
    <!-- End Filter -->

    <!-- Table -->
    <div class="w-full my-3 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full ">
                <thead class="bg-black sticky top-0 z-20">
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase">
                        <th rowspan="2" class="px-4 py-3 border">Tanggal</th>
                        <th colspan="2" class="px-4 py-3 border">Overburden</th>
                        <th colspan="2" class="px-4 py-3 border">Coal</th>
                    </tr>
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase">
                        <th class="px-4 py-3 border">Plan</th>
                        <th class="px-4 py-3 border">ACT</th>
                        <th class="px-4 py-3 border">Plan</th>
                        <th class="px-4 py-3 border">ACT</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($data as $dt)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-center">
                            {{date('d-m-Y', strtotime($dt->tgl))}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->ob_plan}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->ob_act}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->coal_plan}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->coal_act}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Table -->

    <!-- Start Kendala -->
    <div class="w-full my-3 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full ">
                <thead class="bg-black sticky top-0 z-20">
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase">
                        <th rowspan="2" class="px-4 py-3 border">Tanggal</th>
                        <th rowspan="2" class="px-4 py-3 border">Nom Unit</th>
                        <th rowspan="2" class="px-4 py-3 border">Shift</th>
                        <th colspan="2" class="px-4 py-3 border">Waktu</th>
                        <th rowspan="2" class="px-4 py-3 border">Keterangan</th>
                    </tr>
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase">
                        <th class="px-4 py-3 border">Awal</th>
                        <th class="px-4 py-3 border">Akhir</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($kendala as $dt)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-center">
                            {{date('d-m-Y', strtotime($dt->tgl))}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->unit}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->shift}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->awal}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->akhir}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->ket}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Kendala -->
    <hr>
    <h4>Display Comments</h4>

    @include('partials.commentsDisplay', ['comments' => $post->comments, 'post_id' => $post->id])
    <h4>Add comment</h4>
    <form method="post" action="{{ route('comments.store'   ) }}">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="body"></textarea>
            <input type="hidden" name="post_id" value="{{ $post->id }}" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Add Comment" />
        </div>
    </form>
    <hr />

</div>


<script>
    $(function() {
        // OVERBURDEN
        //get the OB data
        var ob_prod = JSON.parse(`<?php echo $data_prod_ob['chart_data_prod_ob']; ?>`);
        var ob_plan = JSON.parse(`<?php echo $data_plan_ob['chart_data_plan_ob']; ?>`);
        var ctx = $("#overburden");

        //Multi Chart
        var data = {
            labels: ob_prod.label,
            datasets: [{
                type: 'bar',
                label: 'Actual',
                data: ob_prod.data,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)'
            }, {
                type: 'line',
                label: 'Plan',
                data: ob_plan.data,
                fill: false,
                borderColor: 'rgb(54, 162, 235)'
            }]
        };

        //options
        var options = {
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "",
                fontSize: 18,
                fontColor: "#111"
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#333",
                    fontSize: 16
                }
            }
        };

        //   Create Mixed Chart
        var chart1 = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });

        // Coal
        //get the Coal data
        var coal_prod = JSON.parse(`<?php echo $data_prod_coal['chart_data_prod_coal']; ?>`);
        var coal_plan = JSON.parse(`<?php echo $data_plan_coal['chart_data_plan_coal']; ?>`);
        var ctx = $("#coal");

        //Multi Chart
        var data = {
            labels: coal_prod.label,
            datasets: [{
                type: 'bar',
                label: 'Actual',
                data: coal_prod.data,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)'
            }, {
                type: 'line',
                label: 'Plan',
                data: coal_plan.data,
                fill: false,
                borderColor: 'rgb(54, 162, 235)'
            }]
        };

        //options
        var options = {
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "",
                fontSize: 18,
                fontColor: "#111"
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    fontColor: "#333",
                    fontSize: 16
                }
            }
        };

        //   Create Mixed Chart
        var chart2 = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });

    });
</script>
@endsection