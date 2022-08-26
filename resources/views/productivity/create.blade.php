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
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview" class="btn btn-primary shadow-md mr-2">Tambah Pty</a>
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
                        <th colspan="14" class="whitespace-nowrap text-center">Waktu</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Jarak</th>
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
                        <td class=" sticky left-0 bg-white">
                            <a href="{{route('super_admin.productivity.edit', $dataPty[$key]->id)}}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="pencil" class="w-5 h-5"></i> </a>
                            <a href="{{route('super_admin.productivity.edit', $dataPty[$key]->id)}}" class="btn btn-danger mr-1 mb-2"> <i data-lucide="trash" class="w-5 h-5"></i> </a>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="text-center">
                        <td colspan="21">
                            <span class="font-bold">Total Produksi</span>: {{number_format($totalDataPty[0]->total_pty) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- end PTY Overview -->

    
    <!-- BEGIN: Modal Content -->
    <div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Transaksi Productivity</h2>
                    <form action="{{route('productivity.check')}}" method="POST">
                    @csrf

                    <select id="modal-form-6" class="form-select w-16" name="jam">
                            @for($i=6; $i<=19; $i++)
                            <option value="{{$i}}" {{old('jam', substr($waktu,0,2)) == $i || old('jam', substr($waktu,1,1)) == $i ? 'selected' : ''}}>{{$i}}</option>
                            @endfor
                        </select> 
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input type="hidden" name="tgl" value="{{\Carbon\Carbon::now()->timezone('Asia/Kuala_lumpur')->format('Y-m-d')}}">
                    <input type="hidden" name="kodesite" value="{{Auth::user()->kodesite}}">
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-6" class="form-label">Nom Unit</label> <select id="modal-form-6" class="form-select" name="nom_unit">
                            @foreach($dataNomUnit as $dnu)
                            <option value="{{$dnu->nom_unit}}">{{$dnu->nom_unit}}</option>
                            @endforeach
                        </select> </div>
                    <div class="col-span-12 sm:col-span-6"> 
                        <label for="modal-form-6" class="form-label">Pit</label> 
                        <select id="modal-form-6" class="form-select" name="pit">
                            @foreach($dataPit as $dp)
                            <option value="{{$dp->ket}}">{{$dp->ket}}</option>
                            @endforeach
                        </select> 
                    </div>
                    <div class="col-span-12 sm:col-span-6"> 
                        <label for="modal-form-2" class="form-label">Pty (bcm)</label> 
                        <input id="modal-form-2" type="text" class="form-control" placeholder="" name="pty">
                        @error('pty')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                     </div>
                    <div class="col-span-12 sm:col-span-6"> 
                        <label for="modal-form-3" class="form-label">Jarak (M)</label> 
                        <input id="modal-form-3" type="text" class="form-control" placeholder="" name="dist">
                        @error('dist')
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
    </div> <!-- END: Modal Content -->

</div>
@endsection