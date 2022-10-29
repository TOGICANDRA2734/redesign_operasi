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
                        <div class="mt-3">
                            <canvas id="report-pie-chart" height="213"></canvas>
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
                            <canvas id="report-pie-chart" height="213"></canvas>
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
                            <canvas id="report-pie-chart" height="213"></canvas>
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
                            <canvas id="report-donut-chart" height="213"></canvas>
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

    <script>
        $(".detailBtn").on("click", function() {
            var id = $(this).data("id");
            var url = $(this).data("url");
            console.log(id, url);

            $i = jQuery.noConflict();
            $i.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: [],
                success: function(response) {
                    console.log()
                    var fullText = "";
                    if (response) {
                        i = 0;
                        $i(".modal-header h2").html("Data Personal - " + response.record1[0].nama)
                        $i.each(response.record1[0], function(index, data) {

                            fullText += "<tr> " +
                                "<th class='whitespace-nowrap bg-dark text-white'>" + response
                                .judulrecord1[i] + "</th>" +
                                "<td>" + data + " </td>" +
                                "</tr>"
                            i += 1;
                        });
                        $i(".table-detail-1 tbody").html(fullText);

                        i = 0;
                        fullText = "";
                        $i.each(response.record2[0], function(index, data) {
                            fullText += "<tr> " +
                                "<th class='whitespace-nowrap bg-dark text-white'>" + response
                                .judulrecord2[i] + "</th>" +
                                "<td>" + data + " </td>" +
                                "</tr>"
                            i += 1;
                        });
                        $i(".table-detail-2 tbody").html(fullText);

                        i = 0;
                        fullText = "";

                        $i.each(response.record3[0], function(index, data) {

                            fullText += "<tr> " +
                                "<th class='whitespace-nowrap bg-dark text-white'>" + response
                                .judulrecord3[i] + "</th>" +
                                "<td>" + data + " </td>" +
                                "</tr>"
                            i += 1;
                        });
                        $i(".table-detail-3 tbody").html(fullText);
                    }
                },
            })

        })
    </script>
@endsection
