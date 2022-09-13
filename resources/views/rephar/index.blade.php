@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
    <div class="">
        <!-- Header -->
        <div class="flex justify-between items-end py-4">
            <!-- Title -->
            <h2 class="text-lg font-medium truncate mr-5 ">
                Report Harian
            </h2>


            <div class="ml-auto flex justify-center items-end">
                
                <select id="pilihSite"
                    class="block shadow-sm border p-2 mr-2 rounded-md w-20  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                    name="kodesite" id="kodesite">
                    <option value="">All Site</option>
                    @foreach ($site as $st)
                        <option value="{{ $st->kodesite }}">{{ $st->namasite }}</option>
                    @endforeach
                </select>
                <input type="text" name="cariNama" id="cariNama" placeholder="Cari Data"
                    class="block shadow-sm border p-2 rounded-md w-30 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray mr-2">
                <div id="filterTanggal" class="form-control box p-2 ml-auto w-10 flex mr-2">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="download"></i> </span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a href="" class="dropdown-item"> EXCEL </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"> PDF </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mb-10">

        <!-- Table -->
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-auto h-[45rem]">
                <table class="w-full table table-sm">
                    <thead class="table-dark sticky left-0 top-0 z-50">
                        <tr class="">
                            <th rowspan="2" class="whitespace-nowrap text-center border">#</th>
                            <th rowspan="2" class="whitespace-nowrap text-center border">Nom Unit</th>
                            <th colspan="6" class="whitespace-nowrap text-center border">Jam Kerja</th>
                            <th rowspan="2" class="whitespace-nowrap text-center border">BD</th>
                            <th rowspan="2" class="whitespace-nowrap text-center border">MOHH</th>
                            <th rowspan="2" class="whitespace-nowrap text-center border">MA(%)</th>
                            <th rowspan="2" class="whitespace-nowrap text-center border">UT(%)</th>
                            <th colspan="18" class="whitespace-nowrap text-center border">Standby Figure</th>
                            <th colspan="4" class="whitespace-nowrap text-center border">Produksi</th>
                            <th colspan="3" class="whitespace-nowrap text-center border">Penggunaan Solar</th>
                        </tr>
                        <tr>
                            <th class="whitespace-nowrap text-center border">OB</th>
                            <th class="whitespace-nowrap text-center border">GEN</th>
                            <th class="whitespace-nowrap text-center border">TRAV</th>
                            <th class="whitespace-nowrap text-center border">RENT</th>
                            <th class="whitespace-nowrap text-center border">COAL</th>
                            <th class="whitespace-nowrap text-center border">TOTAL</th>

                            <th class="whitespace-nowrap text-center border">S00</th>
                            <th class="whitespace-nowrap text-center border">S01</th>
                            <th class="whitespace-nowrap text-center border">S02</th>
                            <th class="whitespace-nowrap text-center border">S03</th>
                            <th class="whitespace-nowrap text-center border">S04</th>
                            <th class="whitespace-nowrap text-center border">S05</th>
                            <th class="whitespace-nowrap text-center border">S06</th>
                            <th class="whitespace-nowrap text-center border">S07</th>
                            <th class="whitespace-nowrap text-center border">S08</th>
                            <th class="whitespace-nowrap text-center border">S09</th>
                            <th class="whitespace-nowrap text-center border">S10</th>
                            <th class="whitespace-nowrap text-center border">S11</th>
                            <th class="whitespace-nowrap text-center border">S12</th>
                            <th class="whitespace-nowrap text-center border">S13</th>
                            <th class="whitespace-nowrap text-center border">S14</th>
                            <th class="whitespace-nowrap text-center border">S15</th>
                            <th class="whitespace-nowrap text-center border">S16</th>
                            <th class="whitespace-nowrap text-center border">S17</th>

                            <th class="whitespace-nowrap text-center border">RITASI</th>
                            <th class="whitespace-nowrap text-center border">JARAK</th>
                            <th class="whitespace-nowrap text-center border">BCM</th>
                            <th class="whitespace-nowrap text-center border">PTY</th>

                            <th class="whitespace-nowrap text-center border">LITER</th>
                            <th class="whitespace-nowrap text-center border">LTR/BCM</th>
                            <th class="whitespace-nowrap text-center border">LTR/JAM</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $dt)
                            <tr
                                class="text-center border @if ($dt->nom_unit == 'SUB TOTAL') bg-gray-600 text-white @else bg-white @endif">
                                <td class="whitespace-nowrap text-center border">
                                    {{ $key + 1 }}
                                </td>
                                @foreach ($dt as $k => $d)
                                    @if ($k != 'k_kode')
                                        @if ($k != 'total_stb')
                                            @if ($k != 'gol')
                                                @if (gettype($d) == 'double')
                                                    @if ($k == 'mohh')
                                                        <td class="whitespace-nowrap text-center border">
                                                            {{ number_format($d, 0) }}
                                                        </td>
                                                    @elseif($k == 'ritasi')
                                                        <td class="whitespace-nowrap text-center border">
                                                            {{ number_format($d, 0) }}
                                                        </td>
                                                    @elseif($k == 'jarak')
                                                        <td class="whitespace-nowrap text-center border">
                                                            {{ number_format($d, 0) }}
                                                        </td>
                                                    @elseif($k == 'bcm')
                                                        <td class="whitespace-nowrap text-center border">
                                                            {{ number_format($d, 0) }}
                                                        </td>
                                                    @elseif($k == 'liter')
                                                        <td class="whitespace-nowrap text-center border">
                                                            {{ number_format($d, 0) }}
                                                        </td>
                                                    @elseif($k == 'ltr_bcm')
                                                        <td class="whitespace-nowrap text-center border">
                                                            {{ number_format($d, 0) }}
                                                        </td>
                                                    @elseif($k == 'ltr_wh')
                                                        <td class="whitespace-nowrap text-center border">
                                                            {{ number_format($d, 0) }}
                                                        </td>
                                                    @else
                                                        <td class="whitespace-nowrap text-center border">
                                                            {{ number_format($d, 1) }}
                                                        </td>
                                                    @endif
                                                @else
                                                    @if ($k == 'nom_unit')
                                                        @if ($dt->nom_unit == 'SUB TOTAL')
                                                            <td
                                                                class="whitespace-nowrap text-center border sticky left-0 z-20 bg-gray-600">
                                                                {{ $d }}
                                                            </td>
                                                        @else
                                                            <td
                                                                class="whitespace-nowrap text-center border sticky left-0 z-20 bg-white">
                                                                {{ $d }}
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td class="whitespace-nowrap text-center border">
                                                            {{ $d }}
                                                        </td>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <script>
        var $j = jQuery.noConflict();


        var start = moment().subtract(29, 'days');
        var end = moment();

        // Overburden Range
        $j('#filterTanggal').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            }
        }, function(start, end, label) {

            var awal = start.format("YYYY-MM-DD");
            var akhir = end.format("YYYY-MM-DD");
            var pilihSite = $("#pilihSite").val() ? $("#pilihSite").val() : "" ;
            var cariNama = $("#cariNama").val() ? $("#cariNama").val() : "" ;

            var $i = jQuery.noConflict();

            if (awal !== null && akhir !== null) {
                $i.ajax({
                    url: '/super_admin/rep-harian?layout=side-menu',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        start: awal,
                        end: akhir,
                        pilihSite: pilihSite,
                        cariNama: cariNama,
                    },
                    success: function(response) {
                        console.log(response);
                    },
                })
            }
        });

        $("#cariNama, #pilihSite").on('change', function(){
            
        });
    </script>

@endsection
