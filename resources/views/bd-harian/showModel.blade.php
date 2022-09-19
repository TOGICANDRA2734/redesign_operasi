@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">            
            {{$dataDok[0]->nom_unit}}
        </h2>

        <!-- Data Dok -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                <table class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800 sticky top-0">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">No</th>
                            <th colspan="3" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">RS/SR/PP</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Uraian</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Keterangan</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Type</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">No.</th>
                            <th class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($dataDok as $key => $dt)
                            <tr class="group data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$key+1}}</td>
                                @foreach($dt as $key => $d)
                                    @if($key != 'nom_unit')
                                        @if(false === strtotime($d))
                                            <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">
                                                @if(is_double($d))
                                                    {{number_format($d, 0, ',', '.')}}
                                                @else
                                                    {{$d}}
                                                @endif    
                                            </td>
                                        @else
                                            @if ($key == 'sn' or $key == 'engine_brand' or $key == 'id' or $key == 'namasite')
                                                <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">
                                                    {{$d}}
                                                </td>
                                            @else
                                                <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">
                                                    <!-- Tanggal  -->
                                                    {{date_format(new DateTime($d), "d/m/Y")}}
                                                </td>
                                            @endif
                                        @endif
                                    @endif    
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-2 py-1 md:px-4 md:py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">
                
            </div>
        </div>

        <!-- Data Desc -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                <table class="w-full whitespace-no-wrap border table-auto">
                    <thead class="bg-stone-800 sticky top-0">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone w-5">No</th>
                            <th rowspan="2" class="px-2 py-1 md:px-4 md:py-3 border-b border-r border-stone">Uraian</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($dataDesc as $key => $dt)
                            <tr class="group data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">{{$key+1}}</td>
                                @foreach($dt as $key => $d)
                                    @if($key != 'nom_unit')
                                        @if(false === strtotime($d))
                                            <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white text-left">
                                                @if(is_double($d))
                                                    {{number_format($d, 0, ',', '.')}}
                                                @else
                                                    {{$d}}
                                                @endif    
                                            </td>
                                        @else
                                            @if ($key == 'sn' or $key == 'engine_brand' or $key == 'id' or $key == 'namasite')
                                                <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">
                                                    {{$d}}
                                                </td>
                                            @else
                                                <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white text-left">
                                                    <!-- Tanggal  -->
                                                    {{date_format(new DateTime($d), "d/m/Y")}}
                                                </td>
                                            @endif
                                        @endif
                                    @endif    
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-2 py-1 md:px-4 md:py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">
                
            </div>
        </div>
</main>

<script>
    function changeColor(el) {
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700');
        $(el).addClass('bg-gray-200', 'text-white');
    };
</script>
@endsection