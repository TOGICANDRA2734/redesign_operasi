@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
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
        }).then(function (e) {

            if (e.value === true) {
                let token = $('meta[name="csrf-token"]').attr('content');
                let _url = `/bd-harian/delete/${id}`;

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
        }).then(function (e) {

            if (e.value === true) {
                let token = $('meta[name="csrf-token"]').attr('content');
                let _url = `/bd-harian-dok/delete/${id}`;

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
                        swal.fire("Error!", 'Ada kesalahan dalam menghapus data.', "error");
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