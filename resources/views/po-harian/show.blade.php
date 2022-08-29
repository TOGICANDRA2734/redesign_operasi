@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
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