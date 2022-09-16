@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Program Analisa Pelumas Unit
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
        <a href="{{route('super_admin.pap.create')}}" class="btn px-2 box mr-2">
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
    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto max-h-[45rem]">
            <table class="w-full table table-striped table-sm text-xs">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">NO</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Nom Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">AKSI</th>
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
                        <td class="cekTbModal flex justify-center">
                            <a href="{{route('super_admin.pap.show', $data[$key]->id)}}" class="btn btn-dark mr-1 mb-2 p-1">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('super_admin.pap.edit', $data[$key]->id) }}" class="btn btn-warning mr-1 mb-2 p-1">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!-- End Table -->

@endsection

@section('script')
<script src="{{ asset('dist/js/ckeditor-classic.js') }}"></script>
<script>
    const inputElement = document.querySelector('input[id="file_pma"]');
    const pond = FilePond.create(inputElement);
    pond.setOptions({
        server: {
            url: 'http://ptrci.co.id/datacenter/public/upload',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        }
    })
</script>

<script>
    $('#btnUbahStatus').on('click', function(event) {
        $('#idVerif').val($(this).val());
    });
</script>
@endsection