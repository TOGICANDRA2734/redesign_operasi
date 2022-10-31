@extends('../layout/' . $layout)

@section('subhead')
    <title>
        PMA 2023</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Sales Report -->
                {{-- <div class="col-span-12 lg:col-span-6 mt-8">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Data Karyawan
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="flex">
                                <div>
                                    <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">
                                        {{$dataTotal[0]->jumlah}}
                                    </div>
                                    <div class="mt-0.5 text-slate-500">Total Karyawan</div>
                                </div>
                                <div
                                    class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5">
                                </div>
                                <div>
                                    <div class="text-slate-500 text-lg xl:text-xl font-medium">{{$dataStatusKaryawan[1]->jumlah}}</div>
                                    <div class="mt-0.5 text-slate-500">{{$dataStatusKaryawan[1]->sttpegawai}}</div>
                                </div>
                                <div
                                    class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5">
                                </div>
                                <div>
                                    <div class="text-slate-500 text-lg xl:text-xl font-medium">{{$dataStatusKaryawan[2]->jumlah}}</div>
                                    <div class="mt-0.5 text-slate-500">{{$dataStatusKaryawan[2]->sttpegawai}}</div>
                                </div>
                            </div>
                            <div class="dropdown md:ml-auto mt-5 md:mt-0">
                                <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false"
                                    data-tw-toggle="dropdown"> Filter by Category <i data-lucide="chevron-down"
                                        class="w-4 h-4 ml-2"></i> </button>
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
                        <div class="report-chart">
                            <canvas id="report-line-chart" height="275" class="mt-6"></canvas>
                        </div>
                    </div>
                </div> --}}
                <!-- END: Sales Report -->
                <!-- BEGIN: Weekly Top Seller -->
                <div class="col-span-12 sm:col-span-6 2xl:col-span-3 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Data Status Karyawan
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-5">
                        <div class="my-3">
                            <canvas id="dataStatusKaryawan" height="250"></canvas>
                        </div>
                        @foreach ($dataStatusKaryawan as $dt )
                        <div class="w-52 sm:w-auto mx-auto mt-5">
                            <div class="flex items-center">
                                {{-- <div class="w-2 h-2 bg-primary rounded-full mr-3"></div> --}}
                                <span class="truncate">{{$dt->sttpegawai}}</span> <span
                                    class="font-medium ml-auto">{{$dt->jumlah}} - {{$dt->persentase}}%</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- END: Weekly Top Seller -->
                <!-- BEGIN: Weekly Top Seller -->
                <div class="col-span-12 sm:col-span-6 2xl:col-span-3 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Data Usia
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-5">
                        <div class="mt-3">
                            <canvas id="dataUsia" height="250"></canvas>
                        </div>
                        @php
                            $i = 0;
                        @endphp
                        @foreach($dataUsia[0] as $key => $dt)
                        <div class="w-52 sm:w-auto mx-auto mt-5">
                            <div class="flex items-center">
                                <span class="truncate">{{$judulDataUsia[$i]}}</span> 
                                <span class="font-medium ml-auto">{{$dt}}</span>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                </div>
                <!-- END: Weekly Top Seller -->
                <!-- BEGIN: Weekly Top Seller -->
                <div class="col-span-12 sm:col-span-6 2xl:col-span-3 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Data Departemen
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-5">
                        <div class="mt-3">
                            <canvas id="dataDept" height="250"></canvas>
                        </div>
                        @foreach ($dataDept as $dt)                            
                        <div class="w-52 sm:w-auto mx-auto mt-5">
                                <div class="flex items-center">
                                    <span class="truncate">{{$dt->DEPT}}</span> 
                                    <span class="font-medium ml-auto">{{$dt->total}} - {{$dt->PERSENTASE}}%</span>
                                </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- END: Weekly Top Seller -->
                <!-- BEGIN: Sales Report -->
                <div class="col-span-12 sm:col-span-6 2xl:col-span-3 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Data Jenis Kelamin
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-5">
                        <div class="mt-3">
                            <canvas id="dataKelamin" height="213"></canvas>
                        </div>
                        @foreach ($dataKelamin as $dt)                            
                        <div class="w-52 sm:w-auto mx-auto mt-8">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>
                                <span class="truncate">{{$dt->kelamin}}</span> <span
                                    class="font-medium ml-auto">{{$dt->total}} - {{$dt->persentase}}%</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- END: Sales Report -->
                
            </div>
        </div>
    </div>

<!-- Chart -->
<script>
    $(function() {
        var $j = jQuery.noConflict();


        // Get the Status Karyawan Data
        var dataStatusKaryawan = JSON.parse(`<?php echo $dataChartStatusKaryawan; ?>`);
        var ctx = $("#dataStatusKaryawan");

        //Multi Chart
        var data = {
            labels: dataStatusKaryawan.label,
            datasets: [{
                type: 'pie',
                label: 'Status Karyawan',
                data: dataStatusKaryawan.data,
                backgroundColor: ['#FF731D', '#1746A2', '#FFCA03', '#4E6C50', '#EEEDDE']
            }]
        };

        //options
        var options = {
            maintainAspectRatio: false,
            title: {
                display: true,
                position: "top",
                text: "",
                fontSize: 18,
                fontColor: "#111"
            },
            legend: {
                display: false
            }
        };

        //   Create Mixed Chart
        var chart1 = new Chart(ctx, {
            type: "pie",
            data: data,
            options: options
        });

        // Usia
        var dataUsia = JSON.parse(`<?php echo $dataChartUsiaKaryawan; ?>`);
        var ctx = $("#dataUsia");

        //Multi Chart
        var data = {
            labels: dataUsia.label,
            datasets: [{
                type: 'pie',
                label: 'Usia Karyawan',
                data: dataUsia.data,
                backgroundColor: ['#FF731D', '#1746A2', '#FFCA03', '#4E6C50', '#EEEDDE']
            }]
        };

        //options
        var options = {
            maintainAspectRatio: false,
            title: {
                display: true,
                position: "top",
                text: "",
                fontSize: 18,
                fontColor: "#111"
            },
            legend: {
                display: false
            }
        };

        //   Create Mixed Chart
        var chart2 = new Chart(ctx, {
            type: "pie",
            data: data,
            options: options
        });

        
        // Usia
        var dataDept = JSON.parse(`<?php echo $dataChartDept; ?>`);
        var ctx = $("#dataDept");

        //Multi Chart
        var data = {
            labels: dataDept.label,
            datasets: [{
                type: 'pie',
                label: 'Departemen Karyawan',
                data: dataDept.data,
                backgroundColor: [ '#1746A2', '#FF731D',  '#FFCA03', '#4E6C50', '#EEEDDE','#EEEDDE','#E0DDAA','#203239','#141E27','#61764B','#9BA17B','#CFB997','#FAD6A5']
            }]
        };

        //options
        var options = {
            maintainAspectRatio: false,
            title: {
                display: true,
                position: "top",
                text: "",
                fontSize: 18,
                fontColor: "#111"
            },
            legend: {
                display: false
            }
        };

        //   Create Mixed Chart
        var chart3 = new Chart(ctx, {
            type: "pie",
            data: data,
            options: options
        });

        // Data Usia
        // Usia
        var dataKelamin = JSON.parse(`<?php echo $dataChartKelamin; ?>`);
        var ctx = $("#dataKelamin");

        //Multi Chart
        var data = {
            labels: dataKelamin.label,
            datasets: [{
                type: 'pie',
                label: 'Departemen Karyawan',
                data: dataKelamin.data,
                backgroundColor: [ '#1746A2', '#FF731D', '#FFCA03', '#4E6C50', '#EEEDDE','#EEEDDE','#E0DDAA','#203239','#141E27','#61764B','#9BA17B','#CFB997','#FAD6A5']
            }]
        };

        //options
        var options = {
            maintainAspectRatio: false,
            title: {
                display: true,
                position: "top",
                text: "",
                fontSize: 18,
                fontColor: "#111"
            },
            legend: {
                display: false
            }
        };

        //   Create Mixed Chart
        var chart3 = new Chart(ctx, {
            type: "pie",
            data: data,
            options: options
        });
    })
</script>
@endsection
