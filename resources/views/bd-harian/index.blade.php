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
        @if(strtolower(Auth::user()->kodesite)=='x' or Auth::user()->hasRole('super_admin'))
        <div class="ml-auto mr-2 flex">
            <input type="text" name="cariNama" id="cariNama" placeholder="Cari Data" class="block shadow-sm border p-2 rounded-md w-30 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray mr-2">
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
        <a href="{{route('super_admin.bd-harian.create')}}" class="btn px-2 box mr-2">
            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
        </a>
    </div>
    <hr class="mb-10">

    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full table table-striped ">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">#</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Code Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">HM/KM</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Site</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Kode Breakdown</th>
                        <th colspan="3" class="whitespace-nowrap text-center">Tanggal</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">PIC</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Aksi</th>
                    </tr>
                    <tr class="">
                        <th class="whitespace-nowrap text-center">Start BD</th>
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
                        <td class="whitespace-nowrap text-center">{{$dt->namasite}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->kode_bd}}</td>
                        <td class="whitespace-nowrap text-center">{{date('d-m-Y', strtotime($dt->tgl_bd))}}</td>
                        <td class="whitespace-nowrap text-center">{{date('d-m-Y', strtotime($dt->tgl_rfu))}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->day}}</td>
                        <td class="whitespace-nowrap text-center">{{$dt->pic}}</td>
                        <td class="whitespace-nowrap text-center">
                            <a href="{{route('super_admin.bd-harian-detail.index', $dt->id)}}" class="btn px-2 btn-dark mr-1 mb-2"> <i data-lucide="eye" class="w-5 h-5"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection