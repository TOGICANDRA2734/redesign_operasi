@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Transaksi Productivity Coal
        </h2>

        <div class="dropdown">
            <button class="dropdown-toggle btn btn-primary shadow-md mr-2" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center "> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#input1"  type="button" class="dropdown-item">Satu PTY</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#input2" class="dropdown-item">Import Excel</a>
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
                        <th rowspan="2" class="whitespace-nowrap text-center">#</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">No Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">PIT</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">AVG</th>
                        <th colspan="13" class="whitespace-nowrap text-center">Waktu</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Remarks</th>
                        @if(Auth::user()->hasRole('super_admin'))
                            <th rowspan="2" class="whitespace-nowrap text-center">Aksi</th>
                        @endif
                    </tr>
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                        @for($i=6; $i<=18; $i++)
                            <th class="whitespace-nowrap text-center">{{$i+1}}</th>
                        @endfor
                    </tr>
                </thead>

                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($dataCoal as $key => $dp)
                    <tr class="text-center">
                        <td class="">
                            {{$key+1}}
                        </td>
                        @foreach($dp as $keys => $d)
                            @if( $keys !== 'id')
                                <td class=" sticky left-0 bg-white">
                                    {{$d}}
                                </td>
                            @endif
                        @endforeach
                        @if(Auth::user()->hasRole('super_admin'))
                        <td class=" sticky left-0 bg-white">
                            <a href="{{route('super_admin.productivity_coal.edit', $dataCoal[$key]->id)}}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="pencil" class="w-5 h-5"></i> </a>
                            <a href="{{route('super_admin.productivity_coal.edit', $dataCoal[$key]->id)}}" class="btn btn-danger mr-1 mb-2"> <i data-lucide="trash" class="w-5 h-5"></i> </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    <tr class="text-center">
                        <td colspan="21">
                            <span class="font-bold">Total Produksi</span>: {{number_format($totalDataCoal[0]->total_rit) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- end PTY Overview -->

    
    <!-- BEGIN: Modal Content -->
    <div id="input1" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Ritasi Coal</h2>
                    <form action="{{route('productivity_coal.check')}}" method="POST">
                    @csrf

                    <select id="modal-form-6" class="form-select w-16" name="jam">
                            @for($i=7; $i<=19; $i++)
                            <option value="{{$i}}" {{old('jam', substr($waktu,0,2)) == $i || old('jam', substr($waktu,1,1)) == $i ? 'selected' : ''}}>{{$i}}</option>
                            @endfor
                        </select> 
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input type="hidden" name="tgl" value="{{\Carbon\Carbon::now()->timezone('Asia/Kuala_lumpur')->format('Y-m-d')}}">
                    <input type="hidden" name="kodesite" value="{{Auth::user()->kodesite}}">
                    
                    <div class="col-span-12 sm:col-span-6"> 
                        <label for="modal-form-6" class="form-label">Pit</label> 
                        <select id="modal-form-6" class="form-select" name="pit">
                            @foreach($dataPit as $dp)
                            <option value="{{$dp->ket}}">{{$dp->ket}}</option>
                            @endforeach
                        </select> 
                    </div>
                    <div class="col-span-12 sm:col-span-6"> 
                        <label for="modal-form-2" class="form-label">Ritasi (MT)</label> 
                        <input id="modal-form-2" type="text" class="form-control" placeholder="" name="rit">
                        @error('pty')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                     </div>
                    <div class="col-span-12 sm:col-span-6"> 
                        <label for="modal-form-4" class="form-label">Ket (KR)</label> 
                        <input id="modal-form-4" type="text" class="form-control" placeholder="" name="ket">
                        @error('ket')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                     </div>
                </div> <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batalkan</button> <button type="submit" class="btn btn-primary w-20">Kirim</button> </div> <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div> 
    <!-- END: Modal Content -->

    
    <!-- BEGIN: Modal Content -->
    <div id="input2" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Import Excel Productivity Coal</h2>
                    <form action="{{route('productivity_coal.import-excel')}}" method="POST" enctype="multipart/form-data">
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