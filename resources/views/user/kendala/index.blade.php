@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Laporan Kendala - {{App\Models\Site::select('namasite')->where('kodesite', Auth::user()->kodesite)->pluck('namasite')->first()}} 
        </h2>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Kendala -->
</div>
@endsection