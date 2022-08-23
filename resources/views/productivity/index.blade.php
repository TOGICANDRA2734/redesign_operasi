@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <h2 class="text-lg font-medium truncate mr-5 mt-8 ">
        Laporan Productivity - {{App\Models\Site::select('namasite')->where('kodesite', Auth::user()->kodesite)->pluck('namasite')->first()}}
    </h2>
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
                        <th rowspan="2" class="whitespace-nowrap text-center">Pit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">AVG</th>
                        <th colspan="13" class="whitespace-nowrap text-center">Waktu</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Jarak</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Remarks</th>
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
                        @foreach($dp as $d)
                        <td class=" sticky left-0 bg-white">
                            {{$d}}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- end PTY Overview -->
</div>
@endsection