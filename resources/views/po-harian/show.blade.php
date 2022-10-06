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
    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full table table-striped ">
                <thead class="table-dark">
                    <tr class="">
                        <th class="whitespace-nowrap text-center">#</th>
                        <th class="whitespace-nowrap text-center">No RS</th>
                        <th class="whitespace-nowrap text-center">Tanggal RS</th>
                        <th class="whitespace-nowrap text-center">No. Item</th>
                        <th class="whitespace-nowrap text-center">CN</th>
                        <th class="whitespace-nowrap text-center">Part Number</th>
                        <th class="whitespace-nowrap text-center">Part Name</th>
                        <th class="whitespace-nowrap text-center">QTY RS</th>
                        <th class="whitespace-nowrap text-center">NO PO</th>
                        <th class="whitespace-nowrap text-center">Tanggal PO</th>
                        <th class="whitespace-nowrap text-center">Supplier</th>
                        <th class="whitespace-nowrap text-center">PN Interchange</th>
                        {{-- <th class="whitespace-nowrap text-center">Estimasi Hari</th>
                        <th class="whitespace-nowrap text-center">Estimasi Tanggal</th> --}}
                        <th class="whitespace-nowrap text-center">QTY PO</th>
                        <th class="whitespace-nowrap text-center">DOK MRS</th>
                        <th class="whitespace-nowrap text-center">NO MRS</th>
                        <th class="whitespace-nowrap text-center">TGL MRS</th>
                        <th class="whitespace-nowrap text-center">QTY MRS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $dt)
                    <tr class="text-center bg-white">
                        <td class="whitespace-nowrap text-center">{{$key + 1}}</td>
                        @foreach ($dt as $d)
                            <td class="whitespace-nowrap text-center">{{$d}}</td>                        
                        @endforeach
                        {{-- <td class="whitespace-nowrap text-center">1000</td> --}}
                        {{-- <td class="whitespace-nowrap text-center">B1</td> --}}
                        {{-- <td class="whitespace-nowrap text-center">12/12/2022</td> --}}
                        {{-- <td class="whitespace-nowrap text-center">12/12/2022</td> --}}
                        {{-- <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white text-center">
                            <a href="{{route('super_admin.po-transaksi-harian.show', 1)}}" class="btn px-2 btn-dark mr-1 mb-2">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="eye"></i> </span>
                            </a>
                            <a href="{{route('super_admin.po-harian.edit', 1)}}" class="btn px-2 btn-warning  mr-1 mb-2">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="pencil"></i> </span>
                            </a>
                            <button onclick="deleteConfirmation(this.id)" id="{{1}}" class="btn px-2 btn-danger mr-1 mb-2">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="trash"></i> </span>
                            </button>

                        </td> --}}
                    </tr>
                    @endforeach
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
                let _url = `/po-harian/delete/${id}`;

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
@endsection