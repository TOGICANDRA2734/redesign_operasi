@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Detail PO Transaksi
        </h2>
        @if(strtolower(Auth::user()->kodesite)=='x' or Auth::user()->hasRole('super_admin'))
        <div class="ml-auto mr-2 flex">
            <input type="month" name="pilihBulan" id="pilihBulan" class="mr-3 shadow-sm border p-2 rounded-md w-30  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray">

            <select id="pilihSite" class="block shadow-sm border p-2 mr-0 rounded-md w-20  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                <option value="">All Site</option>
                @foreach($site as $st)
                <option value="{{$st->kodesite}}">{{$st->namasite}}</option>
                @endforeach
            </select>

            <!-- BEGIN: Notification Content -->
            <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
                <div class="ml-4 mr-4">
                    <div class="font-medium">Data Berhasil Difilter!</div>
                </div>
            </div> <!-- END: Notification Content -->

        </div>
        @endif
        <a href="{{route('super_admin.po-transaksi-harian.create')}}" class="btn px-2 box mr-2">
            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
        </a>
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
    <hr class="mb-10">

    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full table table-striped ">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2">No</th>
                        <th colspan="2" class="whitespace-nowrap text-center">PO</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Supplier</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Item</th>
                        <th colspan="2" class="whitespace-nowrap text-center">MRS</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Status PO</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Aksi</th>
                    </tr>
                    <tr>
                        <th class="whitespace-nowrap text-center">No</th>
                        <th class="whitespace-nowrap text-center">Tanggal</th>
                        <th class="whitespace-nowrap text-center">NO</th>
                        <th class="whitespace-nowrap text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($data) == 0)
                        <div class="bg-red-600 text-white text-center p-3 font-semibold">
                            Data Kosong
                        </div>
                        @else
                        @foreach($data as $key => $dt)
                        <tr class="bg-white">
                            <td class="whitespace-nowrap text-center">{{$key+1}}</td>
                            <td class="whitespace-nowrap text-center">{{$dt->no_po}}</td>
                            <td class="whitespace-nowrap text-center">{{$dt->po_date}}</td>
                            <td class="whitespace-nowrap text-center">{{$dt->supplier}}</td>
                            <td class="whitespace-nowrap text-center">{{$dt->item}}</td>
                            <td class="whitespace-nowrap text-center">{{$dt->no_mrs}}</td>
                            <td class="whitespace-nowrap text-center">{{$dt->mrs_date}}</td>
                            @if($dt->no_mrs != "")
                            <td class="whitespace-nowrap text-center">Terpenuhi</td>
                            @else
                            <td class="whitespace-nowrap text-center">Tidak Terpenuhi</td>
                            @endif
                            <td class="whitespace-nowrap text-center text-center">
                                <a href="{{route('super_admin.po-transaksi-harian.edit', $dt->id)}}" class="tbDetail mr-1 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-amber-400 border border-transparent rounded-md active:bg-amber-800 hover:bg-amber-900 focus:outline-none focus:shadow-outline-purple">
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
                let _url = `/po-transaksi-harian/delete/${id}`;

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
</script>
<script>
    function changeColor(el) {
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700');
        $(el).addClass('bg-gray-200', 'text-white');
    };
</script>
@endsection