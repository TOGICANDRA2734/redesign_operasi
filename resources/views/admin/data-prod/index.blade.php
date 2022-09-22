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
            Produksi Actual - {{ Auth::user()->kodesite != 'X' ? $site[0]->namasite:  $userSite[0]->namasite}}
        </h2>
        
        <div class="ml-auto mr-2">
            <select id="pilihSite" class="block shadow-sm border p-2 mr-0 rounded-md w-20  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                <option value="">Pilih</option>
                @foreach($site as $st)
                <option value="{{$st->kodesite}}">{{$st->namasite}}</option>
                @endforeach
            </select>
        </div>
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
                            <a href="{{route('admin.data-prod.edit', $dt)}}" class="btn btn-warning text-white"><i class="fa-solid fa-pencil"></i></a>
                        </td>
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
            url: 'http://127.0.0.1:8000/data-prod-report?layout=side-menu',
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