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
                        <td class="whitespace-nowrap text-center">{{$dt->no_st}}</td>
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