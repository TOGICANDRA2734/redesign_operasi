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
            <div class="col-span-12 lg:col-span-6 mt-1">
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
            </div>
            <!-- END: Overburden Report -->
            <!-- BEGIN: Coal Report -->
            <div class="col-span-12 lg:col-span-6 mt-1">

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
            </div>
            <!-- END: Coal Report -->
            <!-- BEGIN: Production Report -->
            <div class="col-span-12 sm:col-span-6 mt-4 intro-y">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Produksi</h2>
                    <div class="dropdown ml-auto mt-0 bg-white">
                        <button class="dropdown-toggle btn btn-outline-secondary font-normal" aria-expanded="false" data-tw-toggle="dropdown">
                            Filter <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content overflow-y-auto h-32">
                                <li><a href="" class="dropdown-item">Shift 1</a></li>
                                <li><a href="" class="dropdown-item">Shift 2</a></li>
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
            <div class="col-span-12 sm:col-span-6 mt-4 intro-y">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Kendala</h2>
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
            <form  method="post" action="{{ route('comments.store') }}" class="news__input relative mt-5 grid grid-cols-12 gap-5">
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