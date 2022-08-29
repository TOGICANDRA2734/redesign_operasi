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
            Report Harian
        </h2>
        <div class="w-full sm:w-auto relative ml-auto mt-3 sm:mt-0">
            <form method="POST" action="{{route('super_admin.mohh.post')}}">
            @csrf
            <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-slate-500" data-lucide="search"></i>
            <input type="text" class="form-control w-full sm:w-64 box px-10 ml-auto" placeholder="Cari Report Harian" name="cari_1">
            </form>
            <div class="inbox-filter dropdown absolute inset-y-0 mr-3 right-0 flex items-center" data-tw-placement="bottom-start">
                <i class="dropdown-toggle w-4 h-4 cursor-pointer text-slate-500" role="button" aria-expanded="false" data-tw-toggle="dropdown" data-lucide="chevron-down"></i>
                <form method="POST" action="{{route('super_admin.mohh.post')}}" class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                    @csrf
                    <div class="dropdown-content">
                        <div class="grid grid-cols-12 gap-4 gap-y-3 p-3">
                            <div class="col-span-6">
                                <label for="input-filter-1" class="form-label text-xs">Nama Unit</label>
                                <input id="input-filter-1" type="text" class="form-control flex-1" placeholder="Cth AD45/AD45001" name="cari_2">
                            </div>
                            <div class="col-span-6">
                                <label for="input-filter-3" class="form-label text-xs">Site</label>
                                <select id="input-filter-4" class="form-select flex-1" name="site">
                                    <option value="" selected disabled>Pilih</option>
                                    @foreach($site as $st)
                                        <option value="{{$st->kodesite}}">{{$st->namasite}} - {{$st->lokasi}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6">
                                <label for="input-filter-2" class="form-label text-xs">Bulan</label>
                                <input id="input-filter-2" type="month" class="form-control flex-1" name="bulan">
                            </div>
                            <div class="col-span-12 flex items-center mt-3">
                                <button type="submit" class="btn btn-primary w-32">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr class="mb-10">

    <!-- Table -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full table">
                <thead class="table-dark">
                    <tr class="">
                        <th rowspan="2" class="whitespace-nowrap text-center">#</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Nom Unit</th>
                        <th rowspan="2" class="whitespace-nowrap text-center">Jumlah</th>
                        @for($i=0; $i<31; $i++) 
                            <th class="whitespace-nowrap text-center">{{$i + 1}}</th>
                        @endfor
                        <th rowspan="2" class="whitespace-nowrap text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $dt)
                    <tr class="text-center bg-white">
                        <td class="whitespace-nowrap text-center">
                            {{$key + 1}}
                        </td>
                        @foreach($dt as $key => $d)
                            @if($key !='urut')
                                @if(strtolower($key[0]) =='t')
                                    @if($d != 24)
                                        <td class="whitespace-nowrap text-center text-red-600">
                                            {{$d}}
                                        </td>
                                    @else
                                        <td class="whitespace-nowrap text-center">
                                            {{$d}}
                                        </td>
                                    @endif
                                @else
                                    <td class="whitespace-nowrap text-center">
                                        {{$d}}
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
</div>
@endsection