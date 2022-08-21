@extends('../layout/' . $layout)

@section('subhead')
<title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Laporan Kendala - {{$site[0]->namasite}}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{route('admin.kendala.create')}}" class="btn btn-primary shadow-md mr-2">Tambah Kendala</a>
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="file-plus" class="w-4 h-4 mr-2"></i> New Category </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="users" class="w-4 h-4 mr-2"></i> New Group </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr class="mb-10">
    
    <!-- Start Kendala -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full table table-striped">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">Tanggal</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Nom Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Shift</th>
                        <th colspan="2" class="whitespace-nowrap text-center">Waktu</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Keterangan</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Aksi</th>
                    </tr>
                    <tr class="">
                        <th class="whitespace-nowrap text-center">Awal</th>
                        <th class="whitespace-nowrap text-center">Akhir</th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach($kendala as $dt)
                    <tr class="text-center bg-white">
                        <td class="">
                            {{date('d-m-Y', strtotime($dt->tgl))}}
                        </td>
                        <td class="">
                            {{$dt->unit}}
                        </td>
                        <td class="">
                            {{$dt->shift}}
                        </td>
                        <td class="">
                            {{$dt->awal}}
                        </td>
                        <td class="">
                            {{$dt->akhir}}
                        </td>
                        <td class="">
                            {{$dt->ket}}
                        </td>
                        <td class="">
                            <a href="{{route('admin.kendala.edit', $dt->id)}}" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 rounded-md active:bg-yellow-600 hover:bg-yellow-900 sm:mr-1 cursor-pointer">
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