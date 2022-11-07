@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            History PAP Unit - {{$dataUnit->nom_unit}}
        </h2>
        @if(strtolower(Auth::user()->kodesite)=='x' or Auth::user()->hasRole('super_admin'))
        <div class="ml-auto flex">
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
        

    </div>
    <hr class="mb-10">

    <!-- Table -->
    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto max-h-[45rem]">
            <table class="w-full table table-striped table-sm text-xs">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">#</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Bagian</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Tanggal</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Status</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Rekomendasi</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">File</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $dt)
                    <tr class="bg-white text-center">
                        <td>{{$key+1}}</td>
                        @foreach($dt as $k => $d)
                            @if($k != 'id')
                                @if($k != 'file')

                                <td>{{$d}}</td>
                                @endif
                            @endif
                        @endforeach
                        <td>
                            <a href="{{'http://127.0.0.1:8000' . Storage::url('dokumenPlantPap/'.$dt->file)}}">File</a> 
                        </td>
                        <td class="cekTbModal flex justify-center">
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
            url: 'http://127.0.0.1:8000/upload',
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