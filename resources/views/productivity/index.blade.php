@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Laporan Productivity
        </h2>
        @if(strtolower(Auth::user()->kodesite)=='x' or Auth::user()->hasRole('super_admin'))
        <div class="ml-auto mr-2 flex">
            <input type="month" name="pilihBulan" id="pilihBulan" class="mr-3 shadow-sm border p-2 rounded-md w-30  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray">

            <select id="pilihSite" class="block shadow-sm border p-2 mr-0 rounded-md w-20  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                <option value="">All Site</option>
                @foreach($site as $st)
                <option value="{{$st->kodesite}}">{{$st->namasite}}</option>
                @endforeach
            </select>
        </div>
        @endif
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
                        <th rowspan="2" class="whitespace-nowrap text-center">#</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">No Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Site</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Pit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">AVG</th>
                        <th colspan="14" class="whitespace-nowrap text-center">Waktu</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Jarak</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Remarks</th>
                    </tr>
                    <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                        @for($i=5; $i<=18; $i++)
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


<!-- Filtering -->
<script>
    $('#pilihSite').on('change', function() {
        $i = jQuery.noConflict();
        $i.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $i('meta[name="csrf-token"]').attr('content')
            }
        });

        var kodesite = $i(this).val();
        $bulan = new Date();
        const pilihBulan = $i('#pilihBulan').val() == null ? $i('#pilihBulan').val() : $bulan.getFullYear() + '-' + ($bulan.getMonth()+1).toString();

        if (kodesite == null || kodesite == '') {
            kodesite = 'all';
        }

        console.log("PILIH Site", kodesite, pilihBulan);

        $i.ajax({
            type: "POST",
            url: '/super_admin/productivity?layout=side-menu',
            data: {
                'kodesite': kodesite,
                'pilihBulan': pilihBulan
            },
            success: function(result) {
                $i("table tbody").empty();
                fullText = ""
                if (result) {
                    $i.each(result.data, function(index) {
                        text = '<tr class="text-center bg-white">' +
                            '<td class="">' + result.data[index].nom_unit + '</td>' +
                            '<td class="">' + result.data[index].namasite + '</td>' +
                            '<td class="">' + result.data[index].pit + '</td>' +
                            '<td class="">' + result.data[index].j1 + '</td>' +
                            '<td class="">' + result.data[index].j2 + '</td>' +
                            '<td class="">' + result.data[index].j3 + '</td>' +
                            '<td class="">' + result.data[index].j4 + '</td>' +
                            '<td class="">' + result.data[index].j5 + '</td>' +
                            '<td class="">' + result.data[index].j6 + '</td>' +
                            '<td class="">' + result.data[index].j7 + '</td>' +
                            '<td class="">' + result.data[index].j8 + '</td>' +
                            '<td class="">' + result.data[index].j9 + '</td>' +
                            '<td class="">' + result.data[index].j10 + '</td>' +
                            '<td class="">' + result.data[index].j11 + '</td>' +
                            '<td class="">' + result.data[index].j12 + '</td>' +
                            '<td class="">' + result.data[index].j13 + '</td>' +
                            '<td class="">' + result.data[index].j14 + '</td>' +
                            '<td class="">' + result.data[index].dist + '</td>' +
                            '<td class="">' + result.data[index].ket + '</td>' +
                            '</tr>';
                        fullText += text
                    });
                    $("table tbody").html(fullText);
                }
            },
            error: function(result) {
                console.log("error", result);
            },
        });
    })

    $('#pilihBulan').on('change', function() {
        $i = jQuery.noConflict();
        $i.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $i('meta[name="csrf-token"]').attr('content')
            }
        });

        var kodesite = $i('#pilihSite').val();
        if (kodesite == null || kodesite == '') {
            kodesite = 'all';
        }
        const pilihBulan = $i(this).val();

        console.log("PILIH BULAN", kodesite, pilihBulan);

        $i.ajax({
            type: "POST",
            url: '/super_admin/productivity?layout=side-menu',
            data: {
                'pilihBulan': pilihBulan,
                'kodesite': kodesite,
            },
            success: function(result) {
                $i("table tbody ").empty();
                fullText = ""
                if (result) {
                    $i.each(result.data, function(index) {
                        text = '<tr class="text-center bg-white">' +
                            '<td class="">' + result.data[index].tgl_data + '</td>' +
                            '<td class="">' + result.data[index].ob_1 + '</td>' +
                            '<td class="">' + result.data[index].ob_2 + '</td>' +
                            '<td class="">' + result.data[index].coal_1 + '</td>' +
                            '<td class="">' + result.data[index].coal_2 + '</td>' +
                            '<td class="">' + result.data[index].ach_ob + '</td>' +
                            '<td class="">' + result.data[index].ach_coal + '</td>' +
                            '</tr>';
                        fullText += text
                    });
                    $("table tbody").html(fullText);
                }
            },
            error: function(result) {
                console.log("error", result);
            },
        });
    })
</script>

@endsection