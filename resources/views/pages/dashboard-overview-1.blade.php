@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="hidden sm:block text-lg font-medium truncate mr-5">Produksi ({{date('l, d/m/Y', strtotime($data[0]->tgl))}})</h2>
                        <h2 class="block sm:hidden text-lg font-medium truncate mr-5">Produksi ({{date('d/m/Y', strtotime($data[0]->tgl))}})</h2>
                        <a href="" class="ml-auto flex items-center text-primary">
                            <i data-lucide="refresh-ccw" class="w-4 h-4 mr-3"></i> Refresh
                        </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        @foreach($data as $dt)
                            <!-- START: Card Dashboard -->
                            <div class="col-span-12 sm:col-span-6 xl:col-span-2 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <div class="flex">
                                                <img class="w-8 h-8" src="https://172.172.55.2/gambar/{{$dt->gambar}}" alt="Icon Cuaca">
                                                <div class="text-lg font-medium leading-8 ml-2">{{$dt->namasite}}</div>
                                            </div>
                                            <div class="ml-auto">
                                                <img class="w-8 h-8" src="https://172.172.55.2/pma_cuaca/{{$dt->icon}}" alt="Icon Cuaca">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-slate-500 mt-6">Overburden <span class="text-gray-400 opacity-50">(bcm)</span></div>
                                            <div class="flex justify-between items-center">
                                                <div class="text-lg font-medium leading-8 mt-1 ">{{number_format($dt->ob_act)}}</div>
                                                <div class="ml-auto">
                                                    <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month">
                                                        {{number_format($dt->ob_ach, 1)}}% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-slate-500 mt-3">Coal <span class="text-gray-400 opacity-50">(mt)</span></div>
                                            <div class="flex justify-between items-center">
                                                <div class="text-lg font-medium leading-8 mt-1 ">{{number_format($dt->coal_act)}}</div>
                                                <div class="ml-auto">
                                                    <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month">
                                                        {{number_format($dt->coal_ach, 1)}}% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Card Dashboard -->
                        @endforeach
                    </div>
                </div>
                <!-- END: General Report -->
                <!-- BEGIN: Overbuden Report -->
                <div class="col-span-12 lg:col-span-6 mt-8">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Overburden</h2>
                        <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                            <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                            <input type="text" class="datepicker form-control sm:w-56 box pl-10">
                        </div>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="flex">
                                <div>
                                    <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">{{number_format($data_detail_OB_prod[0]->OB, 0, '.', ',')}}</div>
                                    <div class="mt-0.5 text-slate-500">Actual</div>
                                </div>
                                <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                                <div>
                                    <div class="text-slate-500 text-lg xl:text-xl font-medium">{{number_format($data_detail_OB_plan[0]->OB, 0, '.', ',')}}</div>
                                    <div class="mt-0.5 text-slate-500">Plan</div>
                                </div>
                                <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                                <div>
                                    @if($data_detail_OB_plan[0]->OB != 0)
                                        <div class="text-slate-500 text-lg xl:text-xl font-medium">{{number_format($data_detail_OB_prod[0]->OB / $data_detail_OB_plan[0]->OB * 100)}}%</div>
                                    @else
                                        <div class="text-slate-500 text-lg xl:text-xl font-medium">NA</div>
                                    @endif
                                    <div class="mt-0.5 text-slate-500">ACH</div>
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
                <div class="col-span-12 lg:col-span-6 mt-8">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Coal</h2>
                        <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                            <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                            <input type="text" class="datepicker form-control sm:w-56 box pl-10">
                        </div>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="flex">
                                <div>
                                    <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">{{number_format($data_detail_coal_prod[0]->coal, 0, '.', ',')}}</div>
                                    <div class="mt-0.5 text-slate-500">Actual</div>
                                </div>
                                <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                                <div>
                                    <div class="text-slate-500 text-lg xl:text-xl font-medium">{{number_format($data_detail_coal_plan[0]->coal, 0, '.', ',')}}</div>
                                    <div class="mt-0.5 text-slate-500">Plan</div>
                                </div>
                                <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                                <div>
                                    @if($data_detail_OB_plan[0]->OB != 0)
                                        <div class="text-slate-500 text-lg xl:text-xl font-medium">{{number_format($data_detail_coal_prod[0]->coal / $data_detail_coal_plan[0]->coal * 100)}}%</div>
                                    @else
                                        <div class="text-slate-500 text-lg xl:text-xl font-medium">NA</div>
                                    @endif
                                    <div class="mt-0.5 text-slate-500">ACH</div>
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
                <!-- BEGIN: Productivity Report -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Productivity Report</h2>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <button class="btn box flex items-center text-slate-600 dark:text-slate-300">
                                <i data-lucide="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel
                            </button>
                            <button class="ml-3 btn box flex items-center text-slate-600 dark:text-slate-300">
                                <i data-lucide="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF
                            </button>
                        </div>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="whitespace-nowrap">NO</th>
                                    <th rowspan="2" class="whitespace-nowrap">NOM UNIT</th>
                                    <th rowspan="2" class="text-center whitespace-nowrap">SITE</th>
                                    <th rowspan="2" class="text-center whitespace-nowrap">AVG</th>
                                    <th colspan="13" class="text-center whitespace-nowrap">WAKTU</th>
                                    <th rowspan="2" class="text-center whitespace-nowrap">Jarak</th>
                                    <th rowspan="2" class="text-center whitespace-nowrap">Remarks</th>
                                </tr>
                                <tr>
                                    @for($i=6; $i<=18; $i++)
                                        <th class="text-center whitespace-nowrap">{{$i+1}}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataPty as $key => $dp)

                                    <tr class="intro-x">
                                        <td class="w-5">
                                          {{$key+1}}
                                        </td>
                                        <!-- START: Print Data Productivity -->
                                        @foreach($dp as $dpKey => $d)
                                            @if($dpKey == 'nom_unit')
                                            <td class="text-left">
                                                {{$d}}
                                            </td>
                                            @else
                                            <td class="text-center">
                                                {{$d}}
                                            </td>
                                            @endif
                                        @endforeach
                                        <!-- END: Print Data Productivity -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <nav class="w-full sm:w-auto sm:mr-auto">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="w-4 h-4" data-lucide="chevrons-left"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="w-4 h-4" data-lucide="chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">...</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">...</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="w-4 h-4" data-lucide="chevron-right"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="w-4 h-4" data-lucide="chevrons-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <select class="w-20 form-select box mt-3 sm:mt-0">
                            <option>10</option>
                            <option>25</option>
                            <option>35</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
                <!-- END: Productivity Report -->
            </div>
        </div>
    </div>

<!-- Chart -->
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
                label: 'Overburden',
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
                label: 'Overburden',
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
