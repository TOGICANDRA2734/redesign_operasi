@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
    <main class="h-full overflow-y-auto">
        <div class="mx-auto grid grid-cols-12 gap-4">
            <div class="intro-y flex flex-col sm:flex-row items-center mt-8 col-span-12">
                <h2 class="text-lg font-medium mr-auto">
                    Populasi Unit - {{ $data[0]->model }}
                </h2>
            </div>
            <hr class="mb-3 col-span-12">


            {{-- Data Breakdown --}}
            <div class="w-full overflow-hidden rounded-lg shadow-xs col-span-12 mb-5">
                <div class="intro-y flex flex-col sm:flex-row items-center  col-span-12">
                    <h2 class="text-lg font-medium mr-auto">
                        Data Breakdown
                    </h2>
                </div>
                <hr class="mb-3 col-span-12">

                <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                    <table class="table table-sm table-striped w-full whitespace-no-wrap border">
                        <thead class="table-dark sticky top-0">
                            <tr
                                class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">#</th>
                                <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Code
                                    Unit</th>
                                <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Type
                                    Unit</th>
                                <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">
                                    Keterangan BD</th>
                                <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($dataBD as $key => $dt)
                                <tr class="group data-row text-center text-gray-700 dark:text-gray-400 ease-in-out duration-150"
                                    onclick="changeColor(this)">
                                    <td class="px-4 py-3 text-sm">{{ $key + 1 }}</td>
                                    @foreach ($dt as $key => $d)
                                        @if (false === strtotime($d))
                                            @if (is_double($d))
                                                <td class="px-4 py-3 border">
                                                    {{ number_format($d, 0, ',', '.') }}
                                                </td>
                                            @else
                                                @if($key != 'id')
                                                    <td class="px-4 py-3 border">
                                                        {{ $d }}
                                                    </td>
                                                @endif
                                            @endif
                                        @else
                                            @if ($key == 'sn' or $key == 'engine_brand' or $key != 'id' or $key == 'namasite')
                                                <td class="px-4 py-3 border">
                                                    {{ $d }}
                                                </td>
                                            @else
                                                <td class="px-4 py-3 border">
                                                    <!-- Tanggal  -->
                                                    {{ date_format(new DateTime($d), 'd/m/Y') }}
                                                </td>
                                            @endif
                                        @endif
                                    @endforeach
                                    <td class="">
                                        <a href="{{ route('bd-harian-detail.index', $dt->nom_unit) }}"
                                            class="btn btn-dark p-1 mb-2">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('bd-harian.edit', $dt->id) }}" class="btn btn-warning p-1">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <button onclick="destroy(this.id)" id="{{$dt->id}}" class="btn btn-danger p-1">
                                            <i data-lucide="trash" class="w-4 h-4"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Data RFU -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs col-span-12">
                <div class="intro-y flex flex-col sm:flex-row items-center  col-span-12">
                    <h2 class="text-lg font-medium mr-auto">
                        Data RFU
                    </h2>
                </div>
                <hr class="mb-3 col-span-12">
                <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                    <table class="table table-sm table-striped border">
                        <thead class="table-dark sticky top-0">
                            <tr
                                class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">#</th>
                                <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Code
                                    Unit</th>
                                <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Type
                                    Unit</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($dataRFU as $key => $dt)
                                <tr class="group data-row text-center text-gray-700 dark:text-gray-400 ease-in-out duration-150"
                                    onclick="changeColor(this)">
                                    <td class="px-4 py-3 text-sm">{{ $key + 1 }}</td>
                                    @foreach ($dt as $key => $d)
                                        @if (false === strtotime($d))
                                            <td class="px-4 py-3 border">
                                                @if (is_double($d))
                                                    {{ number_format($d, 0, ',', '.') }}
                                                @else
                                                    {{ $d }}
                                                @endif
                                            </td>
                                        @else
                                            @if ($key == 'sn' or $key == 'engine_brand' or $key == 'id' or $key == 'namasite')
                                                <td class="px-4 py-3 border">
                                                    {{ $d }}
                                                </td>
                                            @else
                                                <td class="px-4 py-3 border">
                                                    <!-- Tanggal  -->
                                                    {{ date_format(new DateTime($d), 'd/m/Y') }}
                                                </td>
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </main>


    <script>
    function destroy(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'APAKAH KAMU YAKIN ?',
            text: "INGIN MENGHAPUS DATA INI!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'BATAL',
            confirmButtonText: 'YA, HAPUS!',
        }).then((result) => {
            if (result.isConfirmed) {
                //ajax delete
                jQuery.ajax({
                    url: `/admin/slider/${id}`,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function (response) {
                        if (response.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'GAGAL!',
                                text: 'DATA GAGAL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                location.reload();
                            });
                        }
                    }
                });
            }
        })
    }
</script>
@endsection
