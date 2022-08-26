@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
    @if(Auth::user()->hasRole(['super_admin','admin']))
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Kirim Data PMA ke HO</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 ">
            <!-- BEGIN: Form Layout -->
            <form action="{{route('transferPma.store')}}" method="POST" class="intro-y box p-5" enctype="multipart/form-data">
                @csrf
                <!-- BEGIN: Form Input FIle -->
                <div class="mt-3">
                    <label>Site</label>
                    <!-- BEGIN: Basic Select -->
                    <div class="mt-2"> 
                        <select data-placeholder="Pilih site" name="site" class="tom-select w-full @error('site') border-danger @enderror">
                            <option value="" selected disabled>Pilih Site</option>
                            @foreach($site as $st)
                            <option value="{{$st->kodesite}}">{{$st->namasite}} - {{$st->lokasi}}</option>
                            @endforeach
                        </select> 
                        @error('site')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </div>
                    <!-- END: Basic Select -->
                </div>

                <div class="mt-3">
                    <label for="file_pma">File PMA (Rar & Zip)</label>
                    <div class="mt-2">
                        <input type="file" id="file_pma" name="file_pma" class="w-full @error('site') border-danger @enderror"/>
                        <!-- <input name="file_pma" id="file_pma" type="file" class="form-control @error('file_pma') border-danger @enderror}}" /> 
                        @error('file_pma')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif -->
                    </div>
                </div>
                <!-- END: Form Input File -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-lg btn-primary w-full mr-1 mb-2 mt-2">Submit</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
    @endif
    
    <div class="grid grid-cols-12 gap-6 {{(Auth::user()->hasRole(['admin','super_admin'])) ? 'mt-5' : 'mt-20' }}">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-auto">
                <div class="w-56 relative text-slate-500">
                    <input type="date" id="tgl" class="form-control box w-56 date-picker">
                </div>
            </div>
        </div>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $dt)
                        <tr class="intro-x">
                            <td class="text-center w-40">
                                {{$key + 1}}
                            </td>
                            @foreach($dt as $keys => $d)
                                @if($keys != 'sv' and $keys!='file')
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

@endsection

@section('script')
    <script src="{{ asset('dist/js/ckeditor-classic.js') }}"></script>
    <!-- <script>
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
    </script> -->
    <script>
        $('#tgl').on('change', function(){
            console.log($(this).val())
            $.ajax({
                url: '/admin/dashboard/detail_filtered/',
                type: 'GET',
                dataType: 'json',
                data: {
                    start: awal,
                    end: akhir,
                },
                success: function(response) {
                    update_data(response)
                },
            })
            
        })

    </script>
@endsection