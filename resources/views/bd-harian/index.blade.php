@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Status Breakdown Harian
        </h2>

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
        
        <div class="mt-5 flex justify-between items-center">
            <a href="{{route('super_admin.bd-harian.create')}}" class="bg-green-600 hover:bg-green-800 duration-150 ease-in-out text-white font-bold py-2 px-4 rounded inline-flex justify-between items-center">
                <i class="fa-solid fa-circle-plus mr-3"></i>    
                <span>Tambah Data</span>
            </a>
            <form class="" action="#" method="GET">
                <input name="nama" id="nama" type="text" placeholder="Cari data" class="p-2 rounded-md mr-3 w-full md:w-auto text-xs md:text-sm" autocomplete="off">
                <button class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-600 border border-transparent rounded-md active:bg-stone-600 hover:bg-stone-700 focus:outline-none focus:shadow-outline-purple">
                    Cari
                </button>
            </form>
        </div>
        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-2 mb-5">
            <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                <table class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800 sticky top-0 z-50">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">No</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone bg-stone-800 left-0 sticky">Nom Unit</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">HM/KM</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Status BD</th>
                            <th colspan="3" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Tanggal</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Keterangan RFU</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">PIC</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Site</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Aksi</th>
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
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white font-bold bg-stone-300 z-10 left-0 sticky">{{$dt->nom_unit}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->hm}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->kode_bd}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{date('d-m-Y', strtotime($dt->tgl_bd))}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{date('d-m-Y', strtotime($dt->tgl_rfu))}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->day}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->ket_tgl_rfu}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->pic}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->namasite}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white text-center">
                                    <a href="{{route('super_admin.bd-harian-detail.index', $dt->id)}}" class="tbDetail mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-800 border border-transparent rounded-md active:bg-stone-800 hover:bg-stone-900 focus:outline-none focus:shadow-outline-purple">
                                        ...
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-2 py-1 md:px-4 md:py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">
                
            </div>
        </div>
</main>

<script>
    function changeColor(el) {
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700');
        $(el).addClass('bg-gray-200', 'text-white');
    };
</script>
@endsection