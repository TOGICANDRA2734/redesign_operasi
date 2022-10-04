@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
    <div class="">
        <!-- Title -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Transaksi Productivity Massal {{ $errors }}
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a id="tambahRow" href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview"
                    class="btn btn-primary shadow-md mr-2">Tambah Pty</a>
            </div>
            <button class=" btn px-2 box" id="addData">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
        </div>
        <hr class="mb-10">
        <!-- Table -->
        <form action="{{ route('productivity.check_massal') }}" method="POST">
            @csrf
            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto max-h-[30rem]">
                    <table class="w-full table table-striped table-sm">
                        <thead class="table-dark sticky top-0 z-20">
                            <tr class="z-20">
                                <th rowspan="2"
                                    class="whitespace-nowrap text-center w-28 sticky left-0 top-0 bg-dark z-30">No Unit</th>
                                <th rowspan="2" class="whitespace-nowrap text-center w-20">Site</th>
                                <th rowspan="2" class="whitespace-nowrap text-center">PIT</th>
                                <th colspan="24" class="whitespace-nowrap text-center">Waktu</th>
                                <th rowspan="2" class="whitespace-nowrap text-center">Jarak</th>
                                <th rowspan="2" class="whitespace-nowrap text-center">Remarks</th>
                            </tr>
                            <tr
                                class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                                @for ($i = -0; $i < 24; $i++)
                                    <th class="whitespace-nowrap text-center">{{ $i + 1 }}</th>
                                @endfor
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($dataNomUnit as $key => $dnu)
                                <tr class="text-center">
                                    <td class="sticky left-0 bg-white z-0">
                                        {{-- <select id="modal-form-6" class="form-select w-28 bg-white " name="nom_unit" >
                                @foreach ($dataNomUnit as $dnu)
                                <option value="{{$dnu->nom_unit}}">{{$dnu->nom_unit}}</option>
                                @endforeach
                            </select> --}}
                                        <input type="text" value="{{ $dnu->nom_unit }}"
                                            class="form-control form-control-sm  w-20" disabled>
                                        <input type="hidden" name="{{ $dnu->nom_unit }}[nom_unit]"
                                            value="{{ $dnu->nom_unit }}">
                                    </td>
                                    <td>
                                        <input type="text" value="{{ Auth::user()->kodesite }}"
                                            class="form-control form-control-sm  w-20" disabled
                                            name="{{ $dnu->nom_unit }}[site]">
                                    </td>
                                    <td>
                                        <select id="modal-form-6" class="form-select form-select-sm w-36"
                                            name="{{ $dnu->nom_unit }}[pit]">
                                            <option value="" selected disabled>Pilih Pit</option>
                                            @foreach ($dataPit as $dp)
                                                <option value="{{ $dp->ket }}">{{ $dp->ket }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @for ($i = 0; $i < 24; $i++)
                                        <td>
                                            <input type="number" step="any" class="form-control form-control-sm w-20"
                                                name="{{ $dnu->nom_unit }}[pty_{{ $i }}]">
                                        </td>
                                    @endfor
                                    <td>
                                        <input type="number" class="form-control form-control-sm  w-20"
                                            name="{{ $dnu->nom_unit }}[dist]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm  w-32"
                                            name="{{ $dnu->nom_unit }}[ket]">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batalkan</button>
                <button type="submit" class="btn btn-primary w-20">Kirim</button>
            </div>



        </form>
        <!-- end PTY Overview -->
    </div>

<script>
            $j("#tambahRow").on('change', function() {
            $j.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $j('meta[name="csrf-token"]').attr('content')
                }
            });

            $j.ajax({
                type: "GET",
                url: 'http://127.0.0.1:8000/rep-harian-add?layout=side-menu',
                data: {
                    'start': awal,
                    'end': akhir,
                    'pilihSite': pilihSite,
                    'cariNama': cariNama,

                },
                success: function(response) {
                    $j("#loading").toggleClass('hidden');
                    console.log(response)
                    $j("table tbody").empty();
                    fullText = ""
                    if (response) {
                        i = 0;
                        $j.each(response.data, function(index) {
                            i += 1;
                            if (response.data[index].nom_unit == 'SUB TOTAL') {
                                text = '<tr class="text-center bg-gray-600 text-white">' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    i +
                                    '</td>' +
                                    '<td class="whitespace-nowrap text-center border sticky left-0 z-20 bg-gray-600 text-white">' +
                                    response
                                    .data[index].nom_unit + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ob, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].gen, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].trav, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].rent, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].coal, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].totalwh, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].bd, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].mohh, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ma, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ut, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s00, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s01, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s02, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s03, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s04, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s05, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s06, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s07, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s08, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s09, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s10, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s11, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s12, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s13, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s14, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s15, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s16, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s17, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ritasi, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].bcm, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].jarak, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].pty, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].liter, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ltr_bcm, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ltr_wh, 0) + '</td>' +
                                    '</tr>';
                            } else {
                                text = '<tr class="text-center bg-white">' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    i +
                                    '</td>' +
                                    '<td class="whitespace-nowrap text-center border sticky left-0 z-20 bg-white">' +
                                    response
                                    .data[index].nom_unit + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ob, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].gen, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].trav, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].rent, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].coal, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].totalwh, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].bd, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].mohh, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ma, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ut, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s00, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s01, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s02, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s03, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s04, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s05, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s06, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s07, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s08, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s09, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s10, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s11, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s12, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s13, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s14, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s15, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s16, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].s17, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ritasi, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].bcm, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].jarak, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].pty, 2) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].liter, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ltr_bcm, 0) + '</td>' +
                                    '<td class="whitespace-nowrap text-center border">' +
                                    number_format(response
                                        .data[index].ltr_wh, 0) + '</td>' +
                                    '</tr>';
                            }
                            fullText += text
                        });
                        $j("table tbody").html(fullText);
                        show_data();
                    }
                },
                error: function(result) {
                    console.log("error", result);
                },
            });
        });

</script>
@endsection
