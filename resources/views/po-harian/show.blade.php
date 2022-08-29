
@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Detail PO
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
                        <th class="whitespace-nowrap text-center w-3">No</th>
                        <th class="whitespace-nowrap text-center">RS/SR Site</th>
                        <th class="whitespace-nowrap text-center">Nomor PO</th>
                        <th class="whitespace-nowrap text-center">Site</th>
                        <th class="whitespace-nowrap text-center">Deskripsi</th>
                        <th class="whitespace-nowrap text-center max-w[50">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @if(count($data) == 0)
                        <div class="bg-red-600 text-white text-center p-3 font-semibold">
                            Data Kosong
                        </div>
                    @else
                        @foreach($data as $key => $dt)
                            <tr class="group data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$key+1}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->no_po}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dataDok[0]->dok_no}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dataBD[0]->kodesite}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->dok_po}}</td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white text-center">
                                    <a href="{{route('super_admin.po-transaksi-harian.show', $dt->id)}}" class="tbDetail cursor-pointer mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-800 border border-transparent rounded-md active:bg-stone-800 hover:bg-stone-900 focus:outline-none focus:shadow-outline-purple">
                                        ...
                                    </a>
                                    <a href="{{route('super_admin.po-harian.edit', $dt->id)}}" class="tbDetail mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-amber-400 border border-transparent rounded-md active:bg-amber-800 hover:bg-amber-900 focus:outline-none focus:shadow-outline-purple">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <button onclick="deleteConfirmation(this.id)" id="{{$dt->id}}" class="tbDetail mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-800 hover:bg-red-900 focus:outline-none focus:shadow-outline-purple">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
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
        <div class="my-3 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Detail PO 
            </h2>
            
            <a href="{{route('super_admin.po-harian.create')}}" class="bg-green-600 hover:bg-green-800 duration-150 ease-in-out text-white font-bold py-2 px-4 rounded inline-flex justify-between items-center">
                <i class="fa-solid fa-circle-plus mr-3"></i>    
                <span>Tambah Data</span>
            </a>
        </div>

        <!-- Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-3 mb-5">
            <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                <table class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800 sticky top-0">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th  class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone w-5">No</th>
                            <th  class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">RS/SR Site</th>
                            <th  class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Nomor PO</th>
                            <th  class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone w-[5rem]">Site</th>
                            <th  class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Deskripsi</th>
                            <th  class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone w-[12rem]">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if(count($data) == 0)
                            <div class="bg-red-600 text-white text-center p-3 font-semibold">
                                Data Kosong
                            </div>
                        @else
                            @foreach($data as $key => $dt)
                                <tr class="group data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                    <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$key+1}}</td>
                                    <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->no_po}}</td>
                                    <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dataDok[0]->dok_no}}</td>
                                    <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dataBD[0]->kodesite}}</td>
                                    <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$dt->dok_po}}</td>
                                    <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white text-center">
                                        <a href="{{route('super_admin.po-transaksi-harian.show', $dt->id)}}" class="tbDetail cursor-pointer mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-800 border border-transparent rounded-md active:bg-stone-800 hover:bg-stone-900 focus:outline-none focus:shadow-outline-purple">
                                            ...
                                        </a>
                                        <a href="{{route('super_admin.po-harian.edit', $dt->id)}}" class="tbDetail mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-amber-400 border border-transparent rounded-md active:bg-amber-800 hover:bg-amber-900 focus:outline-none focus:shadow-outline-purple">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button onclick="deleteConfirmation(this.id)" id="{{$dt->id}}" class="tbDetail mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-800 hover:bg-red-900 focus:outline-none focus:shadow-outline-purple">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
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
    </div>
</main>

<script>
    function deleteConfirmation(id) {
        swal.fire({
            title: "Apakah anda yakin untuk menghapus data?",
            icon:  'question',
            text:  "Data akan dihapus beserta Data Detail yang ada di dalamnya",
            type:  "warning",
            showCancelButton: !0,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            reverseButtons: !0
        }).then(function (e) {

            if (e.value === true) {
                let token = $('meta[name="csrf-token"]').attr('content');
                let _url = `/po-harian/delete/${id}`;

                $.ajax({
                    type: 'POST',
                    url: _url,
                    data: {_token: token},
                    success: function (resp) {
                        if (resp.success) {
                            swal.fire("Data Berhasil dihapus!", resp.message, "success");
                            location.replace(window.location.origin + "/");
                        } else {
                            swal.fire("Error!", 'Ada kesalahan dalam menghapus data', "error");
                        }
                    },
                    error: function (resp) {
                        swal.fire("Error!", 'Ada kesalahan dalam menghapus data Not', "error");
                    }
                });

            } else {
                e.dismiss;
            }

        }, function (dismiss) {
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