@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-5">
        <!-- Header -->
        <div class="flex justify-between items-center mt-8  col-span-12">
            <h2 class="text-lg font-medium ">
                Historical Overhaul
            </h2>
        </div>
        <hr class="mb-5 col-span-12">
        {{-- End: Header --}}


        {{-- Input Form --}}
        <div class="intro-y col-span-12">
            <div class="grid grid-cols-1 gap-3">
                <!-- Start Form -->
                <form action="{{ route('historical-overhaul.store') }}" method="POST" id="storeDok"
                    class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg  dark:bg-gray-800">
                    @csrf
                    <div>
                        <label for="crud-form-1" class="form-label font-semibold text-gray-700 dark:text-gray-400">Code
                            Unit</label>
                        <select data-placeholder="Pilih Code Unit" name="nom_unit" class="tom-select w-full"
                            id="crud-form-1">
                            @foreach ($nom_unit as $dt)
                                <option value="{{ $dt->nom_unit }}">{{ $dt->nom_unit }}</option>
                            @endforeach
                        </select>
                        @error('nom_unit')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    {{-- <div>
                    <label for="crud-form-8" class="form-label font-semibold text-gray-700 dark:text-gray-400">Model</label>

                    <select data-placeholder="Pilih Model" name="model" class="tom-select w-full">
                        @foreach ($model as $dt)
                            <option value="{{$dt->model}}">{{$dt->model}}</option>                            
                        @endforeach
                    </select> 
                </div> --}}


                    <div>
                        <label for="crud-form-2"
                            class="font-semibold text-gray-700 dark:text-gray-400 form-label">Komponen</label>
                        <select data-placeholder="Pilih Komponen" name="komponen" class="tom-select w-full" id="crud-form-2">
                            @foreach ($komponen as $dt)
                                <option value="{{ $dt->komponen }}">{{ $dt->komponen }}</option>
                            @endforeach
                        </select>

                        @error('komponen')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div class="">
                        <label for="crud-form-3"
                            class="form-label font-semibold text-gray-700 dark:text-gray-400">Start</label>
                        @php
                            $waktu = \Carbon\Carbon::now()->format('Y-m-d');
                        @endphp
                        <input value="{{ $waktu }}" id="crud-form-8" type="date" class="form-control w-full"
                            placeholder="Masukkan Start" name="start" id="crud-form-3">
                        @error('start')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div class="">
                        <label for="crud-form-4"
                            class="font-semibold text-gray-700 dark:text-gray-400 form-label">Finish</label>
                        @php
                            $waktu = \Carbon\Carbon::now()->format('Y-m-d');
                        @endphp
                        <input value="{{ $waktu }}" id="crud-form-4" type="date" class="form-control w-full"
                            placeholder="Masukkan Finish" name="finish">
                        @error('finish')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>


                    <div>
                        <label for="crud-form-5"
                            class="font-semibold text-gray-700 dark:text-gray-400 form-label">HM</label>
                        <input id="crud-form-5" type="number" min="0" class="form-control" placeholder="HM"
                            aria-describedby="input-group-3" name="hm">
                        @error('hm')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label for="crud-form-6"
                            class="font-semibold text-gray-700 dark:text-gray-400 form-label">Remark</label>

                        <input id="crud-form-6" type="text" class="form-control" placeholder="Remark"
                            aria-describedby="input-group-3" name="remark">
                            
                            @error('remark')
                            <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                    </div>
                    

                    <button class="col-span-2 btn btn-primary">
                        Submit
                    </button>
                </form>
            </div>
        </div>
        {{-- End: Input Form --}}

        <!-- Table -->
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs col-span-12">
            <div class="w-full overflow-x-auto">
                <table class="w-full table table-striped">
                    <thead class="table-dark">
                        <tr class="">
                            <th rowspan="2" class="whitespace-nowrap text-center">#</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">Code Unit</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">Model</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">Komponen</th>
                            <th colspan="2" class="whitespace-nowrap text-center">Ovh</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">HM</th>
                            <th rowspan="2" class="whitespace-nowrap text-center" style="width: 40rem;">Remark</th>
                        </tr>
                        <tr>
                            <th class="whitespace-nowrap text-center" style="width: 7rem">Start</th>
                            <th class="whitespace-nowrap text-center" style="width: 7rem">Finish</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($data as $keys => $dt)
                            <tr>
                                <td>
                                    {{ $keys + 1 }}
                                </td>
                                @foreach ($dt as $key => $d)
                                    @if ($key != 'del')
                                        @if ($key != 'id')
                                            <td>
                                                {{ $d }}
                                            </td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- End: Table --}}
    </div>


    <!-- BEGIN: Super Large Modal Content -->
    <div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-5">
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="overflow-y-auto max-h-[30rem]">
                        <div class="w-full overflow-y-auto sm:max-h-[20rem] mt-3 mb-3">
                            <h2 class="font-bold mb-2">Data Unit</h2>
                            <div class="grid grid-cols-1 gap-5">
                            </div>
                            <div id="imageUnit" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            </div>

                            <table id='tableUnit' class="w-full whitespace-no-wrap border table-auto">
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Super Large Modal Content -->

    <!-- Filtering -->
    <script>
        $i = jQuery.noConflict();

        $i('#cariNama, #pilihKomponen').on('change', function() {
            $i.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $i('meta[name="csrf-token"]').attr('content')
                }
            });

            const cariNama = $i("#cariNama").val();
            const pilihKomponen = $i("#pilihKomponen").val();

            console.log("PILIH Nama", cariNama, pilihKomponen);

            $i.ajax({
                type: "POST",
                url: 'http://127.0.0.1:8000/historical-ovh-filter?layout=side-menu',
                data: {
                    'cariNama': cariNama,
                    'pilihKomponen': pilihKomponen,
                },
                success: function(result) {
                    $i("table tbody ").empty();
                    fullText = ""
                    if (result) {
                        i = 0;
                        $i.each(result.data, function(index) {
                            i += 1;
                            text = '<tr class="bg-white">' +
                                '<td class="">' + i + '</td>' +
                                '<td class="">' + result.data[index].nom_unit + '</td>' +
                                '<td class="">' + result.data[index].model + '</td>' +
                                '<td class="">' + result.data[index].komponen + '</td>' +
                                '<td class="">' + result.data[index].ovh_start + '</td>' +
                                '<td class="">' + result.data[index].ovh_end + '</td>' +
                                '<td class="">' + result.data[index].hm + '</td>' +
                                '<td class="">' + result.data[index].remark + '</td>' +
                                '</tr>';
                            fullText += text
                        });
                        $i("table tbody").html(fullText);
                        show_data()
                    }
                },
                error: function(result) {
                    console.log("error", result);
                },
            });
        })

        function show_data() {
            Toastify({
                node: $("#success-notification-content")
                    .clone()
                    .removeClass("hidden")[0],
                duration: -1,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
        };
    </script>
@endsection
