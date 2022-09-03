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
            Historical Unit
        </h2>

        <select class="form-control w-24">
            <option class="form-control" value="" disabled selected>Pilih</option>

        </select>
    </div>
    <hr class="mb-10">

    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full table table-striped">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">NO</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Nom Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Brand Type</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">HM</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Status</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    

                </tbody>
            </table>
        </div>
    </div>
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

@endsection