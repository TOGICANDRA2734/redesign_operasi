@extends('../layout/' . $layout)

@section('subhead')
<title>PMA 2023</title>
@endsection

@section('subcontent')
<div class="flex justify-between items-center mt-8 ">
    <h2 class="text-lg font-medium ">
        Edit Populasi Unit
    </h2>
</div>
<hr class="mb-10">

<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12">
        <!-- BEGIN: Form Layout -->
        <form action="" method="" class="intro-y box p-5">
            <div>
                <label for="crud-form-1" class="form-label">Nom Unit</label>
                <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Masukkan Nomor Unit" name="nom_unit">
            </div>
            <div class="mt-3">
                <label for="crud-form-2" class="form-label">Model</label>
                <select data-placeholder="Pilih Model" class="tom-select w-full" id="crud-form-2" name="model">
                    <option value="1" selected>Drilling Machine</option>
                </select>
            </div>
            <div class="mt-3">
                <label for="crud-form-3" class="form-label">Type Unit</label>
                <select data-placeholder="Pilih Type Unit" class="tom-select w-full" id="crud-form-3" name="type_unit">
                    <option value="1" selected>Atlas Copco DM45</option>
                </select>
            </div>
            
            <div class="mt-3">
                <label for="crud-form-4" class="form-label">Serial Number</label>
                <input id="crud-form-4" type="text" class="form-control w-full" placeholder="Masukkan Serial Number" name="sn">
            </div>

            
            <div class="mt-3">
                <label for="crud-form-5" class="form-label">Engine Brand</label>
                <select data-placeholder="Pilih Engine Brand" class="tom-select w-full" id="crud-form-5" name="engine_brand">
                    <option value="1" selected>CAT</option>
                </select>
            </div>

            
            <div class="mt-3">
                <label for="crud-form-6" class="form-label">Engine SN</label>
                <input id="crud-form-6" type="text" class="form-control w-full" placeholder="Masukkan Engine Serial Number" name="engine_sn">
            </div>

            <div class="mt-3">
                <label for="crud-form-7" class="form-label">HP</label>
                <input id="crud-form-7" type="text" class="form-control w-full" placeholder="Masukkan HP" name="HP">
            </div>

            <div class="mt-3">
                <label for="crud-form-8" class="form-label">DO</label>
                <input id="crud-form-8" type="date" class="form-control w-full" placeholder="Masukkan DO" name="do">
            </div>

            
            <div class="mt-3">
                <label for="crud-form-9" class="form-label">PIC 1</label>
                <input id="crud-form-9" type="text" class="form-control w-full" placeholder="Masukkan PIC 1" name="pic_1">
            </div>
            
            <div class="mt-3">
                <label for="crud-form-10" class="form-label">PIC 2</label>
                <input id="crud-form-10" type="text" class="form-control w-full" placeholder="Masukkan PIC 2" name="pic_2">
            </div>
            
            <div class="mt-3">
                <label for="crud-form-11" class="form-label">Height</label>
                <div class="input-group">
                    <input id="crud-form-11" type="text" class="form-control" placeholder="Masukkan Tinggi Unit" aria-describedby="input-group-1">
                    <div id="input-group-1" class="input-group-text">Meter</div>
                </div>
            </div>

            <div class="mt-3">
                <label for="crud-form-12" class="form-label">Width</label>
                <div class="input-group">
                    <input id="crud-form-12" type="text" class="form-control" placeholder="Width" aria-describedby="input-group-2">
                    <div id="input-group-2" class="input-group-text">Meter</div>
                </div>
            </div>

            <div class="mt-3">
                <label for="crud-form-13" class="form-label">Length</label>
                <div class="input-group">
                    <input id="crud-form-13" type="text" class="form-control" placeholder="Length" aria-describedby="input-group-3">
                    <div id="input-group-3" class="input-group-text">Meter</div>
                </div>
            </div>

            <div class="mt-3">
                <label for="crud-form-14" class="form-label">Fuel</label>
                <div class="input-group">
                    <input id="crud-form-14" type="text" class="form-control" placeholder="Fuel" aria-describedby="input-group-4">
                    <div id="input-group-4" class="input-group-text">Liter</div>
                </div>
            </div>

            
            <div class="text-right mt-5">
                <button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                <button type="button" class="btn btn-primary w-24">Save</button>
            </div>
        </form>
        <!-- END: Form Layout -->
    </div>
</div>
@endsection