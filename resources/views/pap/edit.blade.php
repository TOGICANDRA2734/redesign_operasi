@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
    @if(Auth::user()->hasRole(['super_admin','admin']))
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Transaksi PAP</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 ">
            <!-- BEGIN: Form Layout -->
            <form action="{{route('super_admin.pap.store')}}" method="POST" class="intro-y box p-5" enctype="multipart/form-data">
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
                    <label>Code Unit</label>
                    <!-- BEGIN: Basic Select -->
                    <div class="mt-2"> 
                        <select data-placeholder="Pilih Code Unit" name="nom_unit" class="tom-select w-full @error('nom_unit') border-danger @enderror">
                            <option value="" selected disabled>Pilih Unit</option>
                            @foreach($nom_unit as $nu)
                            <option value="{{$nu->nom_unit}}">{{$nu->nom_unit}}</option>
                            @endforeach
                        </select> 
                        @error('nom_unit')
                            <div class="text-danger mt-2">{{$message}}</div>
                        @endif
                    </div>
                    <!-- END: Basic Select -->
                </div>

                <div class="mt-3">
                    <label for="file_pap">File PAP (PDF)</label>
                    <div class="mt-2">
                        <input type="file" id="file_pap" name="file_pap" class="w-full @error('site') border-danger @enderror"/>
                        <!-- <input name="file_pap" id="file_pap" type="file" class="form-control @error('file_pap') border-danger @enderror}}" /> 
                        @error('file_pap')
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
@endsection

@section('script')
    <script src="{{ asset('dist/js/ckeditor-classic.js') }}"></script>
    <!-- <script>
        const inputElement = document.querySelector('input[id="file_pap"]');
        const pond = FilePond.create(inputElement);
        pond.setOptions({
            server: {
                url: 'http://ptrci.co.id/datacenter/publicupload',
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
                url: 'http://ptrci.co.id/datacenter/publicadmin/dashboard/detail_filtered/',
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