@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Status Breakdown Harian
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
            <table class="w-full table table-striped mt-10">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">No</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Nom Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">HM/KM</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Status BD</th>
                        <th colspan="3" class="whitespace-nowrap text-center">Tanggal</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Keterangan RFU</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">PIC</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Site</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Aksi</th>
                    </tr>
                    <tr class="">
                        <th class="whitespace-nowrap text-center">Start</th>
                        <th class="whitespace-nowrap text-center">Plant RFU</th>
                        <th class="whitespace-nowrap text-center">Day</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $dt)
                        <tr class="text-center bg-white">
                            <td class="whitespace-nowrap text-center">{{$key + 1}}</td>
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
                                <a href="{{route('super_admin.bd-harian-detail.index', $dt->id)}}" class="btn btn-dark mr-1 mb-2"> <i data-lucide="eye" class="w-5 h-5"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection