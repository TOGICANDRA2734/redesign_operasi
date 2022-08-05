@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="bg-gray-100 flex-1 p-6 md:mt-16 overflow-hidden">
    <!-- PTY Overview -->
    <!-- Tanggal Produksi -->
    <h2 class="font-bold mb-3 text-xl text-center mt-5">Kendala Report - {{$site[0]->namasite}}</h2>
    <hr class="my-3">
    <a href="{{route('kendala.create')}}" class="px-3 bg-black text-white">Tambah</a>
    <!-- Start Kendala -->
    <div class="w-full my-3 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full ">
                <thead class="bg-black sticky top-0 z-20">
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase">
                        <th rowspan="2" class="px-4 py-3 border">Tanggal</th>
                        <th rowspan="2" class="px-4 py-3 border">Nom Unit</th>
                        <th rowspan="2" class="px-4 py-3 border">Shift</th>
                        <th colspan="2" class="px-4 py-3 border">Waktu</th>
                        <th rowspan="2" class="px-4 py-3 border">Keterangan</th>
                        <th rowspan="2" class="px-4 py-3 border">Aksi</th>
                    </tr>
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase">
                        <th class="px-4 py-3 border">Awal</th>
                        <th class="px-4 py-3 border">Akhir</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($kendala as $dt)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-center">
                            {{date('d-m-Y', strtotime($dt->tgl))}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->unit}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->shift}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->awal}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->akhir}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{$dt->ket}}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{route('kendala.edit', $dt->id)}}" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 rounded-md active:bg-yellow-600 hover:bg-yellow-900 sm:mr-1 cursor-pointer">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Kendala -->
</div>
@endsection