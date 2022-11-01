@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<!-- File baru -->
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 md:mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Detail Site {{$data[0]->namasite}}</h2>
                    <a href="" class="ml-auto flex items-center text-primary">
                    </a>
                </div>
            </div>
            <!-- END: General Report -->
            <!-- BEGIN: Overbuden Report -->
            <!-- <div class="col-span-12 lg:col-span-6 mt-1">
                <div class="intro-y box p-5 sm:mt-5">
                    <div class="flex items-center">
                        <div class="flex">
                            <div>
                                <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">Overburden</div>
                                <div class="mt-0.5 text-slate-500">BCM</div>
                            </div>
                        </div>
                        <div class="dropdown ml-auto md:mt-0">
                            <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown">
                                Filter <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                            </button>
                            <div class="dropdown-menu w-40">
                                <ul class="dropdown-content overflow-y-auto h-32">
                                    @foreach($pit as $pt)
                                    <li><a href="{{route('dashboard.show.filtered', ['site' => $site, 'pit' => $pt->ket])}}" class="dropdown-item">{{$pt->ket}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <canvas id="overburden" class="mt-6"></canvas>
                    </div>
                </div>
            </div> -->
            <!-- END: Overburden Report -->
            <!-- BEGIN: Coal Report -->
            <!-- <div class="col-span-12 lg:col-span-6 mt-1">

                <div class="intro-y box p-5 sm:mt-5">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex">
                            <div>
                                <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">Coal</div>
                                <div class="mt-0.5 text-slate-500">MT</div>
                            </div>
                        </div>
                        <div class="dropdown md:ml-auto mt-5 md:mt-0">
                            <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown">
                                Filter <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                            </button>
                            <div class="dropdown-menu w-40">
                                <ul class="dropdown-content overflow-y-auto h-32">
                                    @foreach($pit as $pt)
                                    <li><a href="" class="dropdown-item">{{$pt->ket}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <canvas id="coal" class="mt-6"></canvas>
                    </div>
                </div>
            </div> -->
            <!-- END: Coal Report -->

            <!-- BEGIN: Overbuden Report -->
            <div class="col-span-12 lg:col-span-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Overburden</h2>
                    <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                        <div id="OverburdenRange" class="form-control box p-2">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex">
                            <div>
                                <div id="obAct" class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">{{number_format($data_detail_OB_prod[0]->OB, 0, '.', ',')}}</div>
                                <div class="mt-0.5 text-slate-500">Actual</div>
                            </div>
                            <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                            <div>
                                <div id="obPlan" class="text-slate-500 text-lg xl:text-xl font-medium">{{number_format($data_detail_OB_plan[0]->OB, 0, '.', ',')}}</div>
                                <div class="mt-0.5 text-slate-500">Plan</div>
                            </div>
                            <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                            <div>
                                @if($data_detail_OB_plan[0]->OB != 0)
                                <div id="obAch" class="text-slate-500 text-lg xl:text-xl font-medium">{{number_format($data_detail_OB_prod[0]->OB / $data_detail_OB_plan[0]->OB * 100)}}%</div>
                                @else
                                <div class="text-slate-500 text-lg xl:text-xl font-medium">NA</div>
                                @endif
                                <div class="mt-0.5 text-slate-500">ACH</div>
                            </div>
                        </div>
                    </div>
                    <div class="relative h-16 w-full sm:h-full" style="position: relative; height: 30vh; width: 100%;">
                        <canvas id="overburden" class="mt-6"></canvas>
                    </div>
                </div>
            </div>
            <!-- END: Overburden Report -->
            <!-- BEGIN: Coal Report -->
            <div class="col-span-12 lg:col-span-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Coal</h2>
                    <form method="POST" action="#" class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                        <div id="CoalRange" class="form-control box p-2">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </form>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex">
                            <div>
                                <div id="coalAct" class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">{{number_format($data_detail_coal_prod[0]->coal, 0, '.', ',')}}</div>
                                <div class="mt-0.5 text-slate-500">Actual</div>
                            </div>
                            <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                            <div>
                                <div id="coalPlan" class="text-slate-500 text-lg xl:text-xl font-medium">{{number_format($data_detail_coal_plan[0]->coal, 0, '.', ',')}}</div>
                                <div class="mt-0.5 text-slate-500">Plan</div>
                            </div>
                            <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                            <div>
                                @if($data_detail_OB_plan[0]->OB != 0)
                                <div id="coalAch" class="text-slate-500 text-lg xl:text-xl font-medium">{{number_format($data_detail_coal_prod[0]->coal / $data_detail_coal_plan[0]->coal * 100)}}%</div>
                                @else
                                <div class="text-slate-500 text-lg xl:text-xl font-medium">NA</div>
                                @endif
                                <div class="mt-0.5 text-slate-500">ACH</div>
                            </div>
                        </div>
                    </div>
                    <div class="relative h-16 w-full sm:h-full" style="position: relative; height: 30vh; width: 100%;">
                        <canvas id="coal" class="mt-6"></canvas>
                    </div>
                </div>
            </div>
            <!-- END: Coal Report -->

            <!-- BEGIN: Production Report -->
            <div class="col-span-12 sm:col-span-6 mt-4 intro-y">
                <!-- Title -->
                <div class="intro-y h-10 flex justify-between items-center">
                    <h2 class="text-lg font-medium ">
                        Produksi
                    </h2>
                    <div class="ml-auto mr-2 flex">
                        <form method="POST" action="#" class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                            <div id="ProduksiRange" class="form-control box p-2">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </form>

                        <!-- BEGIN: Notification Content -->
                        <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
                            <div class="ml-4 mr-4">
                                <div class="font-medium">Data Berhasil Difilter!</div>
                            </div>
                        </div> 
                        <!-- END: Notification Content -->

                    </div>
                </div>

                <div class="overflow-x-auto mt-4">
                    <table class="table rounded-lg">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2" class="text-center whitespace-nowrap">#</th>
                                <th rowspan="2" class="text-center whitespace-nowrap">Tanggal</th>
                                <th colspan="3" class="text-center whitespace-nowrap">Overburden</th>
                                <th colspan="3" class="text-center whitespace-nowrap">Coal</th>
                            </tr>
                            <tr>
                                <th class="text-center whitespace-nowrap">Act</th>
                                <th class="text-center whitespace-nowrap">Plan</th>
                                <th class="text-center whitespace-nowrap">ACH</th>
                                <th class="text-center whitespace-nowrap">Act</th>
                                <th class="text-center whitespace-nowrap">Plan</th>
                                <th class="text-center whitespace-nowrap">ACH</th>
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
                                    {{$dt->ob_act}}
                                </td>
                                <td>
                                    {{$dt->ob_plan}}
                                </td>
                                <td>
                                    {{number_format($dt->ob_act / ($dt->ob_plan ?: 1) *100 ,1) }}
                                </td>

                                <td>
                                    {{$dt->coal_act}}
                                </td>
                                <td>
                                    {{$dt->coal_plan}}
                                </td>
                                <td>
                                    {{number_format($dt->coal_act / ($dt->coal_plan ?: 1) *100 ,1)}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Production Report -->
            <!-- BEGIN: Kendala Report -->
            <div class="col-span-12 sm:col-span-6 mt-4 intro-y">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Kendala</h2>
                    <form method="POST" action="#" class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                        <div id="KendalaRange" class="form-control box p-2">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </form>
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
                            @foreach($kendala as $key => $dt)
                            <tr class="text-center">
                                <td>
                                    {{$key+1}}
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

    <!-- BEGIN: Comments -->
    <div class="bg-white col-span-12 p-5">
        <div class="intro-y mt-5 pt-5">
            <div class="text-base sm:text-lg font-medium">Komentar</div>
            <form method="post" action="{{ route('comments.store') }}" class="news__input relative mt-5 grid grid-cols-12 gap-5">
                @csrf
                <div class="col-span-10">
                    <i data-lucide="message-circle" class="w-5 h-5 absolute my-auto inset-y-0 ml-6 left-0 text-slate-500"></i>
                    <textarea name="body" class="form-control border-transparent bg-slate-100 pl-16 py-6 resize-none" rows="1" placeholder="Komentar"></textarea>
                    <input type="hidden" name="post_id" value="{{ $post->id }}" />
                </div>
                <div class="col-span-2">
                    <button class="btn btn-primary w-full h-full inline-block mr-1 mb-2">Komentar</button>
                </div>
            </form>
        </div>
        <div class="intro-y mt-5 pb-10">
            @include('partials.commentsDisplay', ['comments' => $post->comments, 'post_id' => $post->id])
        </div>
    </div>
    <!-- END: Comments -->
</div>

<!-- Chart -->
<script>
    $(function() {
        var $j = jQuery.noConflict();

        var start = moment().subtract(29, 'days');
        var end = moment();

        // Overburden Range
        $j('#OverburdenRange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {

            var awal = start.format("YYYY-MM-DD");
            var akhir = end.format("YYYY-MM-DD");

            var $i = jQuery.noConflict();

            if (awal !== null && akhir !== null) {
                $i.ajax({
                    url: 'http://ptrci.co.id/datacenter/publicdashboard/detail_filtered/',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        start: awal,
                        end: akhir,
                    },
                    success: function(response) {
                        update_data(response)
                    },
                })
            }


        });


        // Coal Range
        $j('#CoalRange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {
            console.log(start, end, label)
        });

        // Produksi Range
        $j('#ProduksiRange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {
            console.log(start, end, label)
        });

        // Kendala Range
        $j('#KendalaRange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {
            console.log(start, end, label)
        });

        
        function update_data(response) {
            // OVERBURDEN
            var data_prod_ob = response['data_prod_ob'];
            var data_plan_ob = response['data_plan_ob'];

            var data_prod_coal = response['data_prod_coal'];
            var data_plan_coal = response['data_plan_coal'];

            // Overburden
            chart1.config.data.datasets[0].data = data_prod_ob.data;
            chart1.config.data.datasets[1].data = data_plan_ob.data;
            chart1.config.data.labels = data_prod_ob.label;

            // Coal
            chart2.config.data.datasets[0].data = data_prod_coal.data;
            chart2.config.data.datasets[1].data = data_plan_coal.data;
            chart2.config.data.labels = data_prod_coal.label;

            chart1.update();
            chart2.update();
            $j("#obAct").empty();
            $j("#obPlan").empty();
            $j("#obAch").empty();
            $j("#coalAct").empty();
            $j("#coalPlan").empty();
            $j("#coalAch").empty();

            $j("#obAct").append(number_format(response['data_detail_OB_prod'][0].OB, 1));
            $j("#obPlan").append(number_format(response['data_detail_OB_plan'][0].OB, 1));
            $j("#obAch").append(number_format((response['data_detail_OB_prod'][0].OB / response['data_detail_OB_plan'][0].OB) * 100, 1) + '%');
            $j("#coalAct").append(number_format(response['data_detail_coal_prod'][0].coal, 1));
            $j("#coalPlan").append(number_format(response['data_detail_coal_plan'][0].coal, 1));
            $j("#coalAch").append(number_format((response['data_detail_coal_prod'][0].coal / response['data_detail_coal_plan'][0].coal) * 100, 1) + '%');
        }
        

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
            maintainAspectRatio: false,
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
                label: 'Coal',
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
            maintainAspectRatio: false,
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

        function number_format(number, decimals, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

    });
</script>
@endsection