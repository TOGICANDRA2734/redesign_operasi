@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-5">
    <!-- Title -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8 col-span-12">
        <h2 class="text-lg font-medium mr-auto">
            Transaksi Invoice
        </h2>
        <div class="dropdown">
            <button class="dropdown-toggle btn btn-primary shadow-md mr-2" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center "> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#input2" class="dropdown-item">Import Excel</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr class="col-span-12">


    <!-- Input Form -->     
    <div class="intro-y col-span-12">
        <div class="grid grid-cols-1 gap-3">
            <!-- Start Form -->
            <form action="{{route('invoice.store')}}" method="POST" id="storeDok" class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg  dark:bg-gray-800">
                @csrf
                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Tanggal <span class="text-xs text-gray-500">(Bulan-Hari-Tahun)</span>
                        </span>
                        <input value="{{$waktu}}" class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="date" name="tgl" id="tgl" >
                        @error('tgl')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">PIT</span>
                        <select data-placeholder="Pilih Pit" name="pit" class="tom-select w-full @error('pit') border-danger @enderror">
                            <option value="" selected disabled>Pilih Pit</option>
                            @foreach ($pit as $p)
                                <option value="{{$p->ket}}">{{$p->ket}}</option>
                            @endforeach
                        </select> 
                        @error('pit')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            OB
                        </span>
                        <!-- <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="awal" id="awal"> -->
                        <div class="input-group">
                            <div id="input-group-email" class="input-group-text">BCM</div> 
                            <input class="form-control" type="number" step="0.1" min="0" name="ob" id="ob">
                        </div>
                        @error('ob')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Coal
                        </span>
                        <!-- <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="akhir" id="akhir"> -->
                        <div class="input-group">
                            <div id="input-group-email" class="input-group-text">Coal</div> 
                            <input class="form-control" type="number" step="0.1" min="0" name="coal" id="coal">
                        </div>
                        @error('coal')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <div>
                    <label class="block mt-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-400">
                            Jarak
                        </span>
                        <!-- <input class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" type="text" name="akhir" id="akhir"> -->
                        <div class="input-group">
                            <div id="input-group-email" class="input-group-text">M</div> 
                            <input class="form-control" type="number" step="0.1" min="0" name="dist" id="dist">
                        </div>
                        @error('dist')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </label>
                </div>

                <button class="col-span-2 btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
    </div>
    <!-- end Overburden Overview -->

    <!-- Start invoice -->
    <div class="col-span-12 w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full table table-striped">
                <thead class="table-dark">
                    <tr class="">
                        <th class="whitespace-nowrap text-center">#</th>
                        <th class="whitespace-nowrap text-center">Tanggal</th>
                        <th class="whitespace-nowrap text-center">Site</th>
                        <th class="whitespace-nowrap text-center">Pit</th>
                        <th class="whitespace-nowrap text-center">OB</th>
                        <th class="whitespace-nowrap text-center">Coal</th>
                        <th class="whitespace-nowrap text-center">Jarak</th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach($data as $key => $dt)
                        <tr class="text-center bg-white">
                            <td>{{$key + 1}} </td>
                            @foreach ($dt as $k => $d)
                                @if ($k !='id')
                                    <td>{{$d}}</td>                                
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End invoice -->

    <!-- BEGIN: Modal Content -->
    <div id="input2" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Import Excel invoice</h2>
                    {{-- <form action="{{route('invoice.import')}}" method="POST" enctype="multipart/form-data"> --}}
                    @csrf
                </div> 
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12"> 
                        <label for="modal-form-4" class="form-label">Data Excel (XLS)</label> 
                        <input id="modal-form-4" type="file" class="form-control" name="excel">
                        @error('excel')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </div>
                </div> 
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer flex justify-between items-center"> 
                    <div>
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batalkan</button> 
                        <button type="submit" class="btn btn-primary w-20">Kirim</button> 
                    </div>
                </div> <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div> 
    <!-- END: Modal Content -->

</div>
@endsection