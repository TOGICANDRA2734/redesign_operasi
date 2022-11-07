@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
    <div class="flex justify-between items-center mt-8 ">
        <h2 class="text-lg font-medium ">
            Transaksi Breakdown Harian
        </h2>
    </div>
    <hr class="mb-10">

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <!-- BEGIN: Form Layout -->
            <form action="{{ route('bd-harian.store') }}" method="POST"
                class="intro-y box p-5 grid grid-cols-12 gap-5">
                @csrf
                <div class="col-span-12 sm:col-span-6">
                    <label for="crud-form-8" class="form-label">Site</label>
                    <select data-placeholder="Pilih Site" class="tom-select w-full" id="crud-form-8" name="site">
                        @foreach ($site as $st)
                            <option value="{{ $st->kodesite }}">{{ $st->namasite }} - {{ $st->lokasi }}</option>
                        @endforeach
                    </select>
                    @error('site')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="crud-form-1" class="form-label">Code Unit</label>
                    <select data-placeholder="Pilih Type Unit" class="tom-select w-full" id="crud-form-3" name="nom_unit">
                        @foreach ($nom_unit as $nu)
                            <option value="{{ $nu->Nom_unit }}">{{ $nu->Nom_unit }}</option>
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
                <div class="col-span-12 sm:col-span-6">
                    <label for="crud-form-2" class="form-label">Tanggal Breakdown</label>
                    <input id="crud-form-2" type="date" class="form-control w-full"
                        placeholder="Masukkan Tanggal Breakdown" name="tgl_bd">
                    @error('tgl_bd')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>

                <div class="col-span-12 sm:col-span-6">
                    <label for="crud-form-4" class="form-label">Uraian Breakdown</label>
                    <input type="text" class="form-control w-full" placeholder="Masukkan Keterangan Breakdown"
                        id="crud-form-4" name="keterangan">
                    @error('keterangan')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>

                <div class="col-span-12 sm:col-span-6">
                    <label for="crud-form-3" class="form-label">Tanggal RFU</label>
                    <input id="crud-form-3" type="date" class="form-control w-full" placeholder="Masukkan Tanggal RFU"
                        name="tgl_rfu">
                    @error('tgl_rfu')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="crud-form-4" class="form-label">Ket Rencana RFU</label>
                    <input type="text" class="form-control w-full" placeholder="Masukkan Keterangan RFU (Cth: TBA)"
                        id="crud-form-4" name="ket_tgl_rfu">
                    @error('ket_tgl_rfu')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>

                <div class="col-span-12 sm:col-span-6">
                    <label for="crud-form-5" class="form-label">Status BD</label>
                    <select data-placeholder="Pilih Status BD" class="tom-select w-full" id="crud-form-5" name="kode_bd">
                        @foreach ($kode_bd as $data)
                            <option value="{{ $data->kode_bd }}">{{ $data->kode_bd }} - {{ $data->deskripsi_bd }}
                            </option>
                        @endforeach
                    </select>
                    @error('kode_bd')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>

                <div class="col-span-12 sm:col-span-6">
                    <label for="crud-form-6" class="form-label">HM</label>
                    <input type="number" class="form-control w-full" placeholder="Masukkan HM" id="crud-form-6"
                        name="hm" min="0">
                    @error('hm')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>


                <div class="col-span-12 sm:col-span-6">
                    <label for="crud-form-7" class="form-label">PIC</label>
                    <input type="text" class="form-control w-full" placeholder="Masukkan PIC" id="crud-form-7"
                        name="pic">
                    @error('pic')
                        <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                            <div class="px-4 py-2">
                                <p class="text-gray-600 text-sm">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror
                </div>

                <div class="text-right col-span-12">
                    <button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>

        <div class="intro-y col-span-12 w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full table table-striped">
                    <thead class="table-dark">
                        <tr class="">
                            <th rowspan="2" class="whitespace-nowrap text-center">#</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">Code Unit</th>
                            <th colspan="2" class="whitespace-nowrap text-center">Tanggal</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">Ket. Tanggal RFU</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">Kode BD</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">PIC</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">HM</th>
                            <th rowspan="2" class="whitespace-nowrap text-center">Keterangan</th>
                        </tr>
                        <tr>
                            <th class="whitespace-nowrap text-center" style="width: 7rem">Breakdown</th>
                            <th class="whitespace-nowrap text-center" style="width: 7rem">RFU</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($dataTable as $key => $dt)
                            <tr class="text-center bg-white">
                                <td>
                                    {{$key + 1}}
                                </td>
                                @foreach ($dt as $k => $d )
                                    @if ($k !== 'id')
                                        <td>
                                            {{$d}}
                                        </td>
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
