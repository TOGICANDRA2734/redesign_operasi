@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="bg-gray-100 flex-1 p-6 md:mt-16 overflow-hidden">
    <!-- Title -->
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Produksi Actual
    </h2>
    <hr class="mb-10">
    <!-- Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-3">
        <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
            <table class="w-full whitespace-no-wrap border table-auto">
                <thead class="bg-black sticky top-0 z-10">
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                        <th rowspan="2" class="px-4 py-3 border-b border-r border-stone w-20">No</th>
                        <th rowspan="2" class="px-4 py-3 border-b border-r border-stone  sticky left-0 bg-black">No Unit</th>
                        <th rowspan="2" class="px-4 py-3 text-center border-r">Site</th>
                        <th rowspan="2" class="px-4 py-3 text-center border-r">AVG</th>
                        <th colspan="13" class="px-4 py-3 text-center border-r">Waktu</th>
                        <th rowspan="2" class="px-4 py-3 text-center border-r">Jarak</th>
                        <th rowspan="2" class="px-4 py-3 text-center border-r">Remarks</th>
                    </tr>
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                        @for($i=6; $i<=18; $i++)
                            <th class="px-4 py-3 border">{{$i+1}}</th>
                        @endfor
                    </tr>
                </thead>

                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($dataPty as $key => $dp)
                    <tr class="data-row text-center text-gray-700 dark:text-gray-400 ease-in-out duration-150" onclick="changeColor(this)">
                        <td class="p-2 ">
                            {{$key+1}}
                        </td>
                        @foreach($dp as $d)
                        <td class="p-2  sticky left-0 bg-white">
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