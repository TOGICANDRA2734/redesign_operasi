@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Admin Transaksi File PMA</h2>
    </div>
    
    <div class="grid grid-cols-12 gap-6 mt-6">
        <form class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0">
                <div class="w-56 relative text-slate-500">
                    <input type="date" id="tgl" class="form-control box w-56 date-picker" placeholder="Search...">
                </div>
            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-auto">
                <div class="w-56 relative text-slate-500">
                    <input type="text" id="cari" class="form-control w-56 box pr-10" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
                </div>
            </div>
        </form>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible ">
            <table class="table table-report -mt-2 ">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">#</th>
                        <th class="text-center whitespace-nowrap">Site</th>
                        <th class="text-center whitespace-nowrap">Tanggal</th>
                        <th class="text-center whitespace-nowrap">Waktu</th>
                        <th class="text-center whitespace-nowrap">Status</th>
                        <th class="text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $dt)
                        <tr class="intro-x">
                            <td class="text-center w-40">
                                {{$key + 1}}
                            </td>
                            @foreach($dt as $keys => $d)
                                @if($keys != 'sv' and $keys!='file' and $keys!='id')
                                    @if($keys == 'tgl')
                                        <td class="text-center font-medium whitespace-nowrap">
                                            {{date('d-m-Y', strtotime($d))}}
                                        </td>
                                    @else
                                        <td class="text-center font-medium whitespace-nowrap">
                                            {{$d}} 
                                        </td>
                                    @endif
                                @endif
                            @endforeach
                            <td class="w-40 text-center">
                                <div class="flex items-center justify-center {{ $dt->sv == 1 ? 'text-success' : 'text-danger' }}">
                                    @if($dt->sv!=1)
                                        <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> {{$dt->sv==2 ? 'Ditolak' : 'Menunggu Verifikasi' }} 
                                    @else
                                        <a href="{{'http://ptrci.co.id/datacenter/public' . Storage::url('file/'.$dt->file)}}" class="flex justify-center items-center">
                                            <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Terverifikasi 
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center w-10">
                                <button id="btnUbahStatus" value="{{$dt->id}}" data-tw-toggle="modal" data-tw-target="#edit-statust-verifikasi" class="btn btn-warning w-24 mr-1 mb-2">Verifikasi</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        {{$data->links()}}
        <!-- END: Pagination -->
    </div>


    <!-- BEGIN: Modal Content -->
    <div id="edit-statust-verifikasi" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center"> <i data-lucide="edit-2" class="w-16 h-16 text-Warning mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Ubah status Verifikasi?</div>
                        <div class="text-slate-500 mt-2">Data akan tersimpan</div>
                    </div>
                    <div class="px-5 pb-8 text-center flex items-center justify-center"> 
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Batal</button> 
                        <form action="{{route('transferPma.update')}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="idVerif" id="idVerif" value="">
                            <input type="hidden" name="nilaiVerif" value="2">
                            <button type="submit" class="w-24 btn btn-danger mr-1">Tolak</button> 
                        </form>
                        <form action="{{route('transferPma.update')}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="idVerif" id="idVerif" value="">
                            <input type="hidden" name="nilaiVerif" value="1">
                            <button type="submit" class="w-24 btn btn-warning">Verifikasi</button> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- END: Modal Content -->
@endsection

@section('script')
    <script src="{{ asset('dist/js/ckeditor-classic.js') }}"></script>
    <script>
        const inputElement = document.querySelector('input[id="file_pma"]');
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            server: {
                url: '/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }
        })
    </script>

    <script>
        $('#btnUbahStatus').on('click', function(event){
            $('#idVerif').val($(this).val());
        });
    </script>
@endsection