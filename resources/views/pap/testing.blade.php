@extends('../layout/' . $layout)

@section('subhead')
    <title>PMA 2023</title>
@endsection

@section('subcontent')
    <form action="{{route('pap.testing.store')}}" class="dropzone" method="POST">
        @csrf
        <div class="fallback"> <input name="file" type="file" multiple /> </div>
        <div class="dz-message" data-dz-message>
            <div class="text-lg font-medium">Drop files here or click to upload.</div>
            <div class="text-slate-500"> This is just a demo dropzone. Selected files are <span class="font-medium">not</span>
                actually uploaded. </div>
        </div>
    </form>
@endsection
