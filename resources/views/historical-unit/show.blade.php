@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Header -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Historical Unit
        </h2>
        @if(strtolower(Auth::user()->kodesite)=='x' or Auth::user()->hasRole('super_admin'))
        <div class="ml-auto mr-2 flex">
            <input type="text" name="cariNama" id="cariNama" placeholder="Cari Data" class="block shadow-sm border p-2 rounded-md w-30 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray mr-2">
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
        <a href="{{route('super_admin.populasi-unit.create')}}" class="btn px-2 box mr-2">
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
            <table class="w-full table table-striped">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">NO</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Serial Number</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Deskripsi</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">SR/RS</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">HM</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Tanggal Dokumentasi</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">PIC</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Site</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $dt)
                    <tr class="bg-white">
                        <td class="whitespace-nowrap text-center">{{$key+1}}</td>
                        @foreach($dt as $k => $d)
                        @if($k == 'descript')
                        <td class="whitespace-nowrap text-left">{{$d}}</td>
                        @else
                        <td class="whitespace-nowrap text-center">{{$d}}</td>
                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- BEGIN: Super Large Modal Content -->
<div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-5">
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="overflow-y-auto max-h-[30rem]">
                    <div class="w-full overflow-y-auto sm:max-h-[20rem] mt-3 mb-3">
                        <h2 class="font-bold mb-2">Data Unit</h2>
                        <div class="grid grid-cols-1 gap-5">
                        </div>
                        <div id="imageUnit" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        </div>

                        <table id='tableUnit' class="w-full whitespace-no-wrap border table-auto">
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- END: Super Large Modal Content -->

@endsection