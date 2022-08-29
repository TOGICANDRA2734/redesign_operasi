@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            {{$nom_unit[0]->nom_unit}}
        </h2>
        @if(strtolower(Auth::user()->kodesite)=='x')
        <div class="ml-auto">
            <select id="pilihSite" class="block shadow-sm border p-2 mr-0 rounded-md w-20  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                <option value="">Pilih</option>
                @foreach($site as $st)
                <option value="{{$st->kodesite}}">{{$st->namasite}}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="dropdown">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="download"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="" class="dropdown-item"> Excel </a>
                    </li>
                    <li>
                        <a href="" class="dropdown-item"> PDF </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr class="mb-10">

    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <form action="#" method="GET" class="grid grid-cols-2 sm:grid-cols-7 gap-4">
                <div class="sm:col-span-2">
                    <label fo class="font-bold pb-1 text-xs md:text-sm" for="site">Nama Site</label>
                    <select class="p-2 border border-gray-100 rounded-md w-full text-xs md:text-base" name="site" id="site">
                        <option value="" selected>Semua Site</option>

                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="font-bold pb-1 text-xs md:text-sm" for="statusKaryawan">Filter 2</label>
                    <select class="p-2 border border-gray-100 rounded-md w-full text-xs md:text-base" name="statusKaryawan" id="statusKaryawan">
                        <option value="">Semua</option>
                        <option value="STAFF">Opsi 1</option>
                        <option value="NON STAFF">Opsi 2</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="font-bold pb-1 text-xs md:text-sm" for="statusKontrak">Filter 3</label>
                    <select class="p-2 border border-gray-100 rounded-md w-full text-xs md:text-base" name="statusKontrak" id="statusKontrak">
                        <option value="">Semua</option>
                        <option value="habisKontrak">Opsi 1</option>
                        <option value="masihKontrak">Opsi 2</option>
                    </select>
                </div>

                <div class="relative py-2 px-4 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out flex justify-between items-center">
                    <button>Proses</button>
                    <a class="align-middle flex justify-center items-center rounded-md focus:shadow-outline-purple focus:outline-none bg-stone-800 text-white hover:bg-gray-900 duration-150 ease-in-out" @click="toggleConvertMenu" @keydown.escape="closeConvertMenu" aria-label="Account" aria-haspopup="true">
                        <svg class="h-6 w-6" viewBox="-2.5 -5 75 60" preserveAspectRatio="none">
                            <path d="M0,0 l35,50 l35,-50" fill="none" stroke="white" stroke-linecap="round" stroke-width="5" />
                        </svg>
                    </a>
                    <template x-if="isConvertMenuOpen">
                        <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeConvertMenu" @keydown.escape="closeConvertMenu" class="absolute z-50 right-0 top-16 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700" aria-label="submenu">
                            <li class="flex">
                                <form action="#" method="GET" class="w-full">

                                    <button id="btPDF" class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                        <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Excel</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </template>
                </div>
            </form>


            <!-- Data Utama -->
            <table class="w-full table table-striped mt-10">
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
            </table>

            <!-- Data Dok -->
            <div class="flex justify-between items-center mt-10">
                <h3 class="font-bold mt-3 mb-1">
                    Detail
                </h3>
                <a href="{{route('super_admin.bd-harian-dok.create')}}" class="bg-green-600 hover:bg-green-800 duration-150 ease-in-out text-white font-bold py-2 px-4 rounded inline-flex justify-between items-center">
                    <i class="fa-solid fa-circle-plus mr-3"></i>
                    <span>Tambah Data</span>
                </a>
            </div>
            <table class="w-full table table-striped mt-10">
                <thead class="table-dark">
                    <tr class="whitespace-nowrap text-center">
                        <th rowspan="2" class="whitespace-nowrap text-center w-5">No</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Detail Kerusakan</th>
                        <th colspan="3" class="whitespace-nowrap text-center">RS/SR/PP</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Status BD</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Uraian</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Keterangan</th>
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
                        <td class="whitespace-nowrap text-center">{{$dt->uraian_bd}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->dok_type}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->dok_no}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->dok_tgl}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->kode_bd}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->uraian}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->keterangan}}</td>
                        <td class="whitespace-nowrap text-center">
                            <a href="{{route('super_admin.po-harian.show', $dt->id)}}" class="btn btn-dark mr-1 mb-2"> 
                                <i data-lucide="eye" class="w-5 h-5"></i> 
                            </a>
                            <a href="{{route('super_admin.bd-harian-dok.edit', $dt->id)}}" class="btn btn-warning mr-1 mb-2">
                                <i data-lucide="pencil" class="w-5 h-5"></i>
                            </a>
                            <a onclick="deleteConfirmationDetail({{$dt->id}})" class="btn btn-danger mr-1 mb-2">
                                <i data-lucide="trash" class="w-5 h-5"></i>
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
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Nom Unit</th>
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