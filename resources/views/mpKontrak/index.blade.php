@extends('../layout/' . $layout)

@section('subhead')
    <title>
        PMA 2023</title>
@endsection

@section('subcontent')
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Table Kontrak Manpower
        </h2>
        @if (strtolower(Auth::user()->kodesite) == 'x' or Auth::user()->hasRole('super_admin'))
            <div class="ml-auto mr-2 flex">
                <input type="text" name="cariNama" id="cariNama" placeholder="Cari Data"
                    class="block shadow-sm border p-2 rounded-md w-30 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray mr-2">

                <input type="text" name="cariNama" id="cariNama" placeholder="Cari Data"
                    class="block shadow-sm border p-2 rounded-md w-30 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray mr-2">

                <input type="text" name="cariNama" id="cariNama" placeholder="Cari Data"
                    class="block shadow-sm border p-2 rounded-md w-30 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray mr-2">


                <!-- BEGIN: Notification Content -->
                <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success"
                        data-lucide="check-circle"></i>
                    <div class="ml-4 mr-4">
                        <div class="font-medium">Data Berhasil Difilter!</div>
                    </div>
                </div> <!-- END: Notification Content -->

            </div>
        @endif
        <div class="dropdown">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="download"></i>
                </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <form action="{{ route('super_admin.export_data.index') }}" method="POST">

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
    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto max-h-[45rem]">
            <table class="w-full table table-striped">
                <thead class="table-dark">
                    <tr class="">
                        <th class="whitespace-nowrap text-center capitalize">#</th>
                        <th class="whitespace-nowrap text-center capitalize">Site</th>
                        <th class="whitespace-nowrap text-center capitalize">NIK</th>
                        <th class="whitespace-nowrap text-center capitalize">Nama Karyawan</th>
                        <th class="whitespace-nowrap text-center capitalize">Departemen</th>
                        <th class="whitespace-nowrap text-center capitalize">Jabatan</th>
                        <th class="whitespace-nowrap text-center capitalize">Status</th>
                        <th class="whitespace-nowrap text-center capitalize">No. Kontak</th>
                        <th class="whitespace-nowrap text-center capitalize">Usia</th>
                        <th class="whitespace-nowrap text-center capitalize">Masuk Kerja</th>
                        <th class="whitespace-nowrap text-center capitalize">Masa Kerja</th>
                        <th class="whitespace-nowrap text-center capitalize">Pensiun</th>
                        <th class="whitespace-nowrap text-center capitalize">Habis Kontrak</th>
                        <th class="whitespace-nowrap text-center capitalize">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $dt)
                        <tr class="bg-white text-center">
                            <td>{{ $key + 1 }}</td>
                            @foreach ($dt as $k => $d)
                                @if ($k != 'id')
                                    <td>{{$d}}@if($k == 'lengkap')%@endif
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!-- End Table -->


    <!-- BEGIN: Super Large Modal Content -->
    <div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto"></h2>
                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <ul class="nav nav-tabs col-span-12" role="tablist">
                        <li id="example-1-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1"
                                type="button" role="tab" aria-controls="example-tab-1" aria-selected="true"> 
                                Data Personal 1
                            </button> 
                            </li>
                        <li id="example-2-tab" class="nav-item flex-1" role="presentation"> <button
                                class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-2"
                                type="button" role="tab" aria-controls="example-tab-2" aria-selected="false"> Data Personal 2 </button> </li>
                        <li id="example-3-tab" class="nav-item flex-1" role="presentation"> 
                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-3" type="button" role="tab" aria-controls="example-tab-3" aria-selected="false"> 
                                Data Personal 3 
                            </button> 
                        </li>
                    </ul>
                    <div class="tab-content border-l border-r border-b col-span-12">
                        <div id="example-tab-1" class="tab-pane leading-relaxed p-5 active" role="tabpanel" aria-labelledby="example-1-tab"> 
                            <div class="overflow-x-auto col-span-12 md:col-span-6">
                                <table class="table table-hover table-sm table-detail-1">
                                    <tbody>
                                        <tr>
                                            <th class="whitespace-nowrap bg-dark text-white">NIK</th>
                                            <td>@angelinajolie</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="example-tab-2" class="tab-pane leading-relaxed p-5" role="tabpanel" aria-labelledby="example-2-tab">
                            <div class="overflow-x-auto col-span-12 md:col-span-6">
                                <table class="table table-hover table-sm table-detail-2">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                        <div id="example-tab-3" class="tab-pane leading-relaxed p-5" role="tabpanel" aria-labelledby="example-2-tab">
                            <div class="overflow-x-auto col-span-12 md:col-span-6">
                                <table class="table table-hover table-sm table-detail-3">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>

                    
                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer"> <button type="button" data-tw-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1">Cancel</button> 
                </div> <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
    <!-- END: Super Large Modal Content -->

    <script>
        $(".detailBtn").on("click", function() {
            var id = $(this).data("id");
            var url = $(this).data("url");
            console.log(id, url);

            $i = jQuery.noConflict();
            $i.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: [],
                success: function(response) {
                    console.log()
                    var fullText = "";
                    if (response) {
                        i = 0;
                        $i(".modal-header h2").html("Data Personal - " + response.record1[0].nama)
                        $i.each(response.record1[0], function(index, data) {
                            
                            fullText += "<tr> "+
                                            "<th class='whitespace-nowrap bg-dark text-white'>" + response.judulrecord1[i] + "</th>" +
                                            "<td>" + data + " </td>" + 
                                        "</tr>"
                            i +=1;
                        });
                        $i(".table-detail-1 tbody").html(fullText);

                        i = 0;
                        fullText = "";
                        $i.each(response.record2[0], function(index, data) {
                            fullText += "<tr> "+
                                            "<th class='whitespace-nowrap bg-dark text-white'>" + response.judulrecord2[i] + "</th>" +
                                            "<td>" + data + " </td>" + 
                                        "</tr>"
                            i +=1;
                        });
                        $i(".table-detail-2 tbody").html(fullText);

                        i = 0;
                        fullText = "";

                        $i.each(response.record3[0], function(index, data) {
                            
                            fullText += "<tr> "+
                                            "<th class='whitespace-nowrap bg-dark text-white'>" + response.judulrecord3[i] + "</th>" +
                                            "<td>" + data + " </td>" + 
                                        "</tr>"
                            i +=1;
                        });
                        $i(".table-detail-3 tbody").html(fullText);
                    }
                },
            })

        })
    </script>
@endsection
