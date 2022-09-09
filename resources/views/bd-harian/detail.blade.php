@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Detail Unit -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs mt-6">
        <div class="w-full overflow-x-auto">
            <!-- Data Utama -->

            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 ">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            General Report
                        </h2>
                    </div>
                    <div class="report-box-2 intro-y mt-5">
                        <div class="box grid grid-cols-12">
                            <div class="col-span-12 lg:col-span-4 px-8 py-3 flex flex-col justify-center items-center">
                                <!-- <i data-lucide="pie-chart" class="w-10 h-10 text-pending"></i> -->
                                <img src="https://products.unitedtractors.com/wp-content/uploads/2021/03/PC500LC-10R.png" class="w-36 h-36" alt="Unit Image">
                                <div class="justify-start flex items-center text-slate-600 dark:text-slate-300 mt-8"> Code Unit <i data-lucide="alert-circle" class="tooltip w-4 h-4 ml-1.5" title="Code Unit"></i> </div>
                                <div class="flex items-center justify-start mt-2">
                                    <div class="relative text-2xl font-medium"> {{$data[0]->nom_unit}} </div>
                                </div>
                                <div class="mt-2 text-slate-500 text-xs">{{$data[0]->namasite}}</div>
                                <!-- <button class="btn btn-outline-secondary relative justify-start rounded-full mt-12">
                                    Download Reports
                                    <span class="w-8 h-8 absolute flex justify-center items-center bg-primary text-white rounded-full right-0 top-0 bottom-0 my-auto ml-auto mr-0.5"> <i data-lucide="arrow-right" class="w-4 h-4"></i> </span>
                                </button> -->
                            </div>
                            <div class="col-span-12 lg:col-span-8 p-8 border-t lg:border-t-0 lg:border-l border-slate-200 dark:border-darkmode-300 border-dashed">
                                <div class="tab-content px-5 pb-5">
                                    <div class="tab-pane active grid grid-cols-12 gap-y-8 gap-x-10" id="weekly-report" role="tabpanel" aria-labelledby="weekly-report-tab">
                                        <div class="col-span-6 sm:col-span-6 md:col-span-4">
                                            <div class="text-slate-500">HM/KM</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-base">{{$data[0]->hm}}</div>
                                                <!-- <div class="text-danger flex text-xs font-medium tooltip cursor-pointer ml-2" title="2% Lower than last month"> 2% <i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i> </div> -->
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 md:col-span-4">
                                            <div class="text-slate-500">Status BD</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-base">{{$data[0]->kode_bd}} - {{$data[0]->deskripsi_bd}}</div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 md:col-span-4">
                                            <div class="text-slate-500">Tanggal Breakdown</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-base">{{$data[0]->tgl_bd_format}}</div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 md:col-span-4">
                                            <div class="text-slate-500">Plant RFU</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-base">{{$data[0]->tgl_rfu_format}}</div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 md:col-span-4">
                                            <div class="text-slate-500">Total Hari BD</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-base">{{$data[0]->day}} Hari</div>
                                                <!-- <div class="text-success flex text-xs font-medium tooltip cursor-pointer ml-2" title="52% Higher than last month"> 52% <i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div> -->
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 md:col-span-4">
                                            <div class="text-slate-500">Keterangan RFU</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-base">{{$data[0]->ket_tgl_rfu ? $data[0]->ket_tgl_rfu : ""}}</div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 md:col-span-4">
                                            <div class="text-slate-500">PIC</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-base">{{$data[0]->pic}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
            </div>


            <!-- <table class="w-full table table-striped">
                <thead class="table-dark">
                    <tr class="whitespace-nowrap text-center">
                        <th rowspan="2" class="whitespace-nowrap text-center">No</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Nom Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">HM/KM</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Status BD</th>
                        <th colspan="3" class="whitespace-nowrap text-center">Tanggal</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Keterangan RFU</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">PIC</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Site</th>
                        <th rowspan="2" class="whitespace-nowrap text-center w-[8rem]">Aksi</th>
                    </tr>
                    <tr class="whitespace-nowrap text-center">
                        <th class="whitespace-nowrap text-center">Start</th>
                        <th class="whitespace-nowrap text-center">Plant RFU</th>
                        <th class="whitespace-nowrap text-center">Day</th>
                    </tr>
                </thead>

                <tbody class="text-center bg-white">
                    @foreach($data as $dt)
                    <tr class="">
                        <td class="whitespace-nowrap text-center">{{$dt->id}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->nom_unit}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->hm}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->kode_bd}}</td>
                        <td class="whitespace-nowrap text-center">{{date('d-m-Y', strtotime($dt->tgl_bd))}}</td>
                        <td class="whitespace-nowrap text-center">{{date('d-m-Y', strtotime($dt->tgl_rfu))}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->day}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->ket_tgl_rfu}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->pic}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->namasite}}</td>
                        <td class="whitespace-nowrap text-center">
                            <a href="{{route('super_admin.bd-harian.edit', $dt->id)}}" class="btn btn-warning mr-1 mb-2">
                                <i data-lucide="pencil" class="w-5 h-5"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> -->

            <!-- Data Dok -->
            <!-- Title -->
            <div class="flex justify-between items-center mt-8 ">
                <h2 class="text-lg font-medium ">
                    Detail
                </h2>
                <div class="ml-auto mr-2 flex">
                    <input type="month" name="pilihBulan" id="pilihBulan" class="mr-2 shadow-sm border p-2 rounded-md w-30  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray">

                    <select id="pilihSite" class="block shadow-sm border p-2 mr-0 rounded-md w-20  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                        <option value="">All Site</option>
                    </select>

                    <!-- BEGIN: Notification Content -->
                    <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
                        <div class="ml-4 mr-4">
                            <div class="font-medium">Data Berhasil Difilter!</div>
                        </div>
                    </div> <!-- END: Notification Content -->

                </div>
                <button class="btn px-2 box mr-2">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                </button>

                <div class="dropdown">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="download"></i> </span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <form action="{{route('super_admin.export_data.index')}}" method="POST">

                                    <button type="submit" class="dropdown-item"> Excel </button>
                                </form>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"> PDF </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="my-5">

            <table class="w-full table table-striped mt-10">
                <thead class="table-dark">
                    <tr class="whitespace-nowrap text-center">
                        <th rowspan="2" class="whitespace-nowrap text-center w-5">No</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Item Code</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Item Name</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Deskripsi BD</th>
                        <th colspan="3" class="whitespace-nowrap text-center">RS/SR/PP</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Progress</th>
                        <th rowspan="2" class="whitespace-nowrap text-center w-[12rem]">Aksi</th>
                    </tr>
                    <tr class="whitespace-nowrap text-center">
                        <th class="whitespace-nowrap text-center">Type</th>
                        <th class="whitespace-nowrap text-center">No.</th>
                        <th class="whitespace-nowrap text-center">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @if($dataDok == "Data Kosong")
                    <div class="bg-red-600 text-white text-center p-3 font-semibold">
                        Data Kosong
                    </div>
                    @else
                    @foreach($dataDok as $key => $dt)
                    <tr class="whitespace-nowrap text-center">
                        <td class="whitespace-nowrap text-center">{{$key+1}}</td>
                        <td class="whitespace-nowrap text-center"></td>
                        <td class="whitespace-nowrap text-center"></td>
                        <td class="whitespace-nowrap text-center">{{$dt->uraian_bd}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->dok_type}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->dok_no}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->dok_tgl}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->uraian}}</td>
                        <td class="whitespace-nowrap text-center">
                            <a href="{{route('super_admin.po-harian.show', 1)}}" class="btn px-2 btn-dark mr-1 mb-2">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="eye"></i> </span>
                            </a>
                            <a href="{{route('super_admin.bd-harian-dok.edit', 1)}}" class="btn px-2 btn-warning  mr-1 mb-2">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="pencil"></i> </span>
                            </a>
                            <a onclick="deleteConfirmationDetail({{1}})" class="btn px-2 btn-danger mr-1 mb-2">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="trash"></i> </span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('subcontent')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$nom_unit[0]->nom_unit}}
        </h2>

        <!-- Data Utama -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                <table class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800 sticky top-0">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">No</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Code Unit</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">HM/KM</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Status BD</th>
                            <th colspan="3" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Tanggal</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Keterangan RFU</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">PIC</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Site</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone w-[8rem]">Aksi</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Start</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Plant RFU</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Day</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $dt)
                        <tr class="group data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->id}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->nom_unit}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->hm}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->kode_bd}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{date('d-m-Y', strtotime($dt->tgl_bd))}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{date('d-m-Y', strtotime($dt->tgl_rfu))}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->day}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->ket_tgl_rfu}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->pic}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->namasite}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white text-center">
                                <a href="{{route('super_admin.bd-harian.edit', $dt->id)}}" class="tbDetail mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-amber-400 border border-transparent rounded-md active:bg-amber-800 hover:bg-amber-900 focus:outline-none focus:shadow-outline-purple">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Data Dok -->
        <div class="flex justify-between items-center">
            <h3 class="font-bold mt-3 mb-1 text-xl">
                Detail
            </h3>
            <a href="{{route('super_admin.bd-harian-dok.create')}}" class="bg-green-600 hover:bg-green-800 duration-150 ease-in-out text-white font-bold py-2 px-4 rounded inline-flex justify-between items-center">
                <i class="fa-solid fa-circle-plus mr-3"></i>
                <span>Tambah Data</span>
            </a>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-3 mb-5">
            <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                <table class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800 sticky top-0">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone w-5">No</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Detail Kerusakan</th>
                            <th colspan="3" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">RS/SR/PP</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Status BD</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Uraian</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Keterangan</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone w-[12rem]">Aksi</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Type</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">No.</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if($dataDok == "Data Kosong")
                        <div class="bg-red-600 text-white text-center p-3 font-semibold">
                            Data Kosong
                        </div>
                        @else
                        @foreach($dataDok as $key => $dt)
                        <tr class="group data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$key+1}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->uraian_bd}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->dok_type}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->dok_no}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->dok_tgl}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->kode_bd}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->uraian}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->keterangan}}</td>
                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white text-center flex flex-col sm:flex-row justify-center items-center">
                                <a href="{{route('super_admin.po-harian.show', $dt->id)}}" class="tbDetail cursor-pointer mt-1 sm:mt-0 sm:mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-800 border border-transparent rounded-md active:bg-stone-800 hover:bg-stone-900 focus:outline-none focus:shadow-outline-purple">
                                    ...
                                </a>
                                <a href="{{route('super_admin.bd-harian-dok.edit', $dt->id)}}" class="tbDetail cursor-pointer mt-1 sm:mt-0 sm:mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-amber-400 border border-transparent rounded-md active:bg-amber-800 hover:bg-amber-900 focus:outline-none focus:shadow-outline-purple">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a onclick="deleteConfirmationDetail({{$dt->id}})" class="tbDetail cursor-pointer mt-1 sm:mt-0 sm:mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-800 hover:bg-red-900 focus:outline-none focus:shadow-outline-purple">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="px-2 py-1 md:px-4 md:py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">

            </div>
        </div>
</main>

<script>
    function deleteConfirmation(id) {
        swal.fire({
            title: "Apakah anda yakin untuk menghapus data?",
            icon: 'question',
            text: "Data akan dihapus beserta Data Detail yang ada di dalamnya",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            reverseButtons: !0
        }).then(function(e) {

            if (e.value === true) {
                let token = $('meta[name="csrf-token"]').attr('content');
                let _url = `/bd-harian/delete/${id}`;

                $.ajax({
                    type: 'POST',
                    url: _url,
                    data: {
                        _token: token
                    },
                    success: function(resp) {
                        if (resp.success) {
                            swal.fire("Data Berhasil dihapus!", resp.message, "success");
                            location.replace(window.location.origin + "/");
                        } else {
                            swal.fire("Error!", 'Ada kesalahan dalam menghapus data', "error");
                        }
                    },
                    error: function(resp) {
                        swal.fire("Error!", 'Ada kesalahan dalam menghapus data Not', "error");
                    }
                });

            } else {
                e.dismiss;
            }

        }, function(dismiss) {
            return false;
        })
    }

    function deleteConfirmationDetail(id) {
        swal.fire({
            title: "Apakah anda yakin untuk menghapus data?",
            icon: 'question',
            text: "Data akan dihapus beserta Data Detail yang ada di dalamnya",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            reverseButtons: !0
        }).then(function(e) {

            if (e.value === true) {
                let token = $('meta[name="csrf-token"]').attr('content');
                let _url = `/bd-harian-dok/delete/${id}`;

                $.ajax({
                    type: 'POST',
                    url: _url,
                    data: {
                        _token: token
                    },
                    success: function(resp) {
                        if (resp.success) {
                            swal.fire("Data Berhasil dihapus!", resp.message, "success");
                            location.replace(window.location.origin + "/");
                        } else {
                            swal.fire("Error!", 'Ada kesalahan dalam menghapus data', "error");
                        }
                    },
                    error: function(resp) {
                        swal.fire("Error!", 'Ada kesalahan dalam menghapus data.', "error");
                    }
                });

            } else {
                e.dismiss;
            }

        }, function(dismiss) {
            return false;
        })
    }
</script>

<script>
    function changeColor(el) {
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700');
        $(el).addClass('bg-gray-200', 'text-white');
    };
</script>
@endsection