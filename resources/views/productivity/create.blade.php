@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Transaksi Productivity
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
                        <a href="{{route('productivity-create.index')}}" class="dropdown-item">Massal</a>

                        {{-- <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#input2" class="dropdown-item">Massal</a> --}}
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
                        <th rowspan="2" class="whitespace-nowrap text-center">Site</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">PIT</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">AVG</th>
                        <th colspan="24" class="whitespace-nowrap text-center">Waktu</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Jarak</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Remarks</th>
                        @if(Auth::user()->hasRole('super_admin'))
                            <th rowspan="2" class="whitespace-nowrap text-center">Aksi</th>
                        @endif
                    </tr>
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                        @for($i=0; $i<24; $i++)
                            <th class="whitespace-nowrap text-center">{{$i}}</th>
                        @endfor
                    </tr>
                </thead>

                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($dataPty as $key => $dp)
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
                        @if (Auth::user()->hasRole('super_admin'))
                        <td class=" sticky left-0 bg-white">
                            <a href="{{route('super_admin.productivity.edit', $dataPty[$key]->id)}}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="pencil" class="w-5 h-5"></i> </a>
                            <a href="{{route('super_admin.productivity.edit', $dataPty[$key]->id)}}" class="btn btn-danger mr-1 mb-2"> <i data-lucide="trash" class="w-5 h-5"></i> </a>
                        </td>    
                        @endif
                    </tr>
                    @endforeach
                    <tr class="text-center">
                        <td colspan="38">
                            <span class="font-bold">Total Produksi</span>: {{number_format($totalDataPty[0]->total_pty) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- end PTY Overview -->

    <!-- BEGIN: Modal Content -->
    <div id="input2" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Import Excel Productivity</h2>
                    <form action="{{route('productivity.import-excel')}}" method="POST" enctype="multipart/form-data">
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