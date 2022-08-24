@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Header -->
    <div class="flex justify-between items-center py-4">
        <!-- Title -->
        <h2 class="text-lg font-medium truncate mr-5 ">
            Produksi Actual - {{ Auth::user()->kodesite != 'X' ? $site[0]->namasite: 'HO - All Site'}}
        </h2>
        @if(Auth::user()->kodesite=='X')
        <select class="form-control w-24">
            <option class="form-control" value="" disabled selected>Pilih</option>
            @foreach($site as $st)
                <option class="form-control" value="{{$st->namasite}}">{{$st->namasite}}</option>
            @endforeach
        </select>
        @endif
    </div>
    <hr class="mb-10">

    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full table table-striped">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">Tanggal</th>
                        <th colspan="2" class="whitespace-nowrap text-center">Overburden</th>
                        <th colspan="2" class="whitespace-nowrap text-center">Coal</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Aksi</th>
                    </tr>
                    <tr class="">
                        <th class="whitespace-nowrap text-center">Shift 1</th>
                        <th class="whitespace-nowrap text-center">Shift 2</th>
                        <th class="whitespace-nowrap text-center">Shift 1</th>
                        <th class="whitespace-nowrap text-center">Shift 2</th>
                    </tr>
                </thead>
                <tbody>
                    

                    @foreach($period as $key => $dt)
                        <tr class="text-center bg-white">
                            <td class="">
                                {{date('d-m-Y', strtotime($dt))}}
                            </td>
                            @foreach($data[$key] as $keys => $dtS)
                                @if($keys !== 'id')
                                    <td class="">
                                        {{$dtS}}
                                    </td>
                                @endif
                            @endforeach
                            <td class="">
                                <a href="{{route('data-prod.edit', $dt)}}" class="btn btn-warning text-white"><i class="fa-solid fa-pencil"></i></a>
                            </td>
                        </tr>
                    @endforeach

                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection