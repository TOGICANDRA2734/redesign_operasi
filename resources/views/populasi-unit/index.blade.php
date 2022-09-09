@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="">
    <!-- Title -->
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Populasi Unit
        </h2>
        @if(strtolower(Auth::user()->kodesite)=='x' or Auth::user()->hasRole('super_admin'))
        <div class="ml-auto mr-2 flex">
            <input type="text" name="cariNama" id="cariNama" placeholder="Cari Data" class="block shadow-sm border p-2 rounded-md w-30 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray mr-2">
            <select id="pilihSite" class="block shadow-sm border p-2 mr-0 rounded-md w-20  text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray" name="kodesite" id="kodesite">
                <option value="">All Site</option>
                @foreach($site as $st)
                <option value="{{$st->kodesite}}">{{$st->namasite}}</option>
                @endforeach
            </select>

            <!-- BEGIN: Notification Content -->
            <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
                <div class="ml-4 mr-4">
                    <div class="font-medium">Data Berhasil Difilter!</div>
                </div>
            </div> <!-- END: Notification Content -->

        </div>
        @endif
        <a href="{{route('super_admin.populasi-unit.create')}}" class="btn px-2 box mr-2">
            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
        </a>

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
            <table class="w-full table table-striped text-xs">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">NO</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Nom Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Model</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">DO</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">SITE</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Type Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">S/N</th>
                        <th colspan="3" class="whitespace-nowrap text-center">Engine</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">HP</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Fuel</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">HM</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">KM</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">AKSI</th>
                    </tr>
                    <tr class="">
                        <th class="whitespace-nowrap text-center">Brand</th>
                        <th class="whitespace-nowrap text-center">Model</th>
                        <th class="whitespace-nowrap text-center">SN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $dt)
                    <tr class="bg-white text-center">
                        <td>{{$key+1}}</td>
                        @foreach($dt as $k => $d)
                        @if($k != 'id')
                        <td>{{$d}}</td>
                        @endif
                        @endforeach
                        <td class="cekTbModal">
                            <button href="javascript:;" value="{{$data[$key]->id}}" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview" class="tbDetail btn btn-dark mr-1 mb-2">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                            <a href="{{ route('super_admin.populasi-unit.edit', 1) }}" class="tbDetail btn btn-warning mr-1 mb-2">
                                <i data-lucide="edit" class="w-5 h-5"></i>
                            </a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- BEGIN: Super Large Modal Content -->
<div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-5">
            <div class="modal-header">
                <h2 class="font-bold mb-2 text-xl">Data Unit</h2>

            </div>
            <div class="modal-body">

                <div class="overflow-y-auto max-h-[30rem]">
                    <div class="w-full overflow-y-auto sm:max-h-[20rem] mt-3 mb-3">
                        <div class="grid grid-cols-1 gap-5">
                        </div>
                        <div id="imageUnit" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        </div>

                        <table id='tableUnit' class="table table-striped sm:mt-2 table-auto">
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- END: Super Large Modal Content -->

<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $i = jQuery.noConflict();

    // Search by userid
    $i('.cekTbModal .tbDetail').on('click', function() {
        console.log("HALOOO")
        var userid = $i('.cekTbModal .tbDetail').val();
        console.log(userid);


        if (userid >= 0) {
            // AJAX POST request
            $i.ajax({
                url: '{{ route("super_admin.populasi-unit.showUser") }}',
                type: 'post',
                data: {
                    _token: CSRF_TOKEN,
                    userid: userid
                },
                success: function(response) {
                    createRows(response);
                    console.log(response);
                }
            });
        }
    });

    // Create table rows
    function createRows(response) {
        var len = 0;
        $i('#tableUnit tbody').empty(); // Empty <tbody>
        $i('#imageUnit').empty(); // Empty <tbody>
        if (response['data'] != null) {
            len = response['data'].length;
        }

        if (len > 0) {
            var image =
                "<img class='rounded-md pb-3 w-full' src='https://images.unsplash.com/photo-1622645636770-11fbf0611463?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1473&q=80' alt=''/>" +
                "<img class='rounded-md pb-3 w-full' src='https://images.unsplash.com/photo-1622645636770-11fbf0611463?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1473&q=80' alt=''/>";
            $i("#imageUnit").append(image);

            var tr_str =
                "<tr class=''>" +
                "<th>NOM UNIT</th>" +
                "<td>" + response['data'][0].nom_unit + "</td>" +
                "</tr>" +
                "<tr class=''>" +
                "<th>DO</th>" +
                "<td>" + dateConverter(response['data'][0].DO) + "</td>" +
                "</tr>" +
                "<tr class=''>" +
                "<th>Height</th>" +
                "<td>" + response['data'][0].height + "</td>" +
                "</tr>" +
                "<tr class=''>" +
                "<th>Width</th>" +
                "<td>" + response['data'][0].width + "</td>" +
                "</tr>" +
                "<tr class=''>" +
                "<th>Length</th>" +
                "<td>" + response['data'][0].length + "</td>" +
                "</tr>";
            $i("#tableUnit tbody").append(tr_str);
        } else {
            var tr_str = "<tr>" +
                "<td align='center' colspan='" + response['data'][0][value].length + "'>No record found.</td>" +
                "</tr>";

            $i("#tableUnit tbody").append(tr_str);
        }
    }

    function dateConverter($value) {
        var date = $value.split('-');
        return date[2] + '-' + date[1] + '-' + date[0];
    }

    function monthDifference(d1, d2) {
        var months;
        months = (d2.getFullYear() - d1.getFullYear()) * 12;
        months -= d1.getMonth();
        months += d2.getMonth();
        return months;
    }
</script>

@endsection