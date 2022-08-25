@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Laporan Produksi
        </h2>
        @if(strtolower(Auth::user()->kodesite)=='x')
        <div class="ml-auto">
            <select id="pilihSite" class="block shadow-sm border p-2 mr-0 rounded-md w-20  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                <option value="">Pilih</option>
                @foreach($site as $st)
                <option value="{{$st->kodesite}}">{{$st->namasite}}</option>
                @endforeach
            </select>
        </div>
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
                        <th colspan="2" class="whitespace-nowrap text-center">ACH</th>
                    </tr>
                    <tr class="">
                        <th class="whitespace-nowrap text-center">Shift 1</th>
                        <th class="whitespace-nowrap text-center">Shift 2</th>
                        <th class="whitespace-nowrap text-center">Shift 1</th>
                        <th class="whitespace-nowrap text-center">Shift 2</th>
                        <th class="whitespace-nowrap text-center">OB</th>
                        <th class="whitespace-nowrap text-center">Coal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $dt)
                    <tr class="text-center bg-white">
                        @foreach($dt as $d)
                        <td class="">
                            {{$d}}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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

        const kodesite = $i(this).val();
        $i.ajax({
            type: "POST",
            url: '/admin/data-prod-report?layout=side-menu',
            data: {
                'kodesite': kodesite
            },
            success: function(result) {
                $i("table tbody").empty();
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