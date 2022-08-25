@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')

<!-- BEGIN: Content -->
<div>
<div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Edit Data Productivity
        </h2>
    </div>
    <div class="grid grid-cols-12 mt-5">
        <div class="intro-y col-span-12">
            <!-- BEGIN: Form Layout -->
            <form action="{{route('super_admin.productivity_coal.update', 1)}}" method="POST" class="intro-y box p-5">
                @csrf
                @method('PUT')
                <div class="">
                    @foreach($data as $key => $dt)
                        <h2 class="form-label mt-2 font-semibold uppercase">Jam - {{$dt->jam}}</h2>
                        <div class="flex bg-gray-100 mt-3 rounded-md p-2">
                            <input type="hidden" name="total" value="{{$countAll[0]->total_data}}">
                            <input type="hidden" name="id_{{$key}}" value="{{$dt->id}}">
                            <div class="flex-1 px-5 py-2">
                                <label for="crud-form-1" class="form-label">Rit</label>
                                <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Input text" value="{{$dt->rit}}" name="rit_{{$key}}">
                            </div>
                            
                            
                            <div class="flex-1 px-5 py-2">
                                <label for="crud-form-1" class="form-label">Remarks </label>
                                <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Input text" value="{{$dt->ket}}" name="remarks_{{$key}}">
                            </div>
                            
                            <div class="flex-1 px-5 py-2">
                                <label for="crud-form-1" class="form-label">Pit </label>
                                <!-- <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Input text" value="{{$dt->pit}}" name="pit_{{$key}}"> -->
                                <select id="modal-form-6" class="form-select" name="pit_{{$key}}">
                                    @foreach($dataPit as $dp)
                                        <option value="{{$dp->ket}}">{{$dp->ket}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-right mt-5">
                    <button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
</div>
<!-- END: Content -->
@endsection