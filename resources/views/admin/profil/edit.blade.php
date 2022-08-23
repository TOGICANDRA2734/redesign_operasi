@extends('../layout/' . $layout)

@section('subhead')
<title>Update Profile - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Ubah Profil</h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                <div class="w-12 h-12 image-fit">
                    <img alt="User Image" class="rounded-full" src="{{Auth::user()->getPhotoAttribute()}}">
                </div>
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">{{Auth::user()->name}} <span class="text-gray-300 opacity-50 text-sm font-light">{{Auth::user()->username}}</span></div>
                    <div class="text-slate-500">{{Auth::user()->posisi}}</div>
                </div>
            </div>
            <ul role="tablist" class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                <li id="personal-information-tab" role="presentation" class="tab flex items-center">
                    <button id="btnPersonalInformation" class="flex nav-item" data-tw-toggle="pill" data-tw-target="#personal-information" type="button" role="tab" aria-controls="personal-information" aria-selected="true">
                        <i data-lucide="activity" class="w-4 h-4 mr-2"></i> Data Pribadi
                    </button>
                </li>
                <li id="add-account-tab" role="presentation" class="tab flex items-center mt-5">
                    <button id="btnAddAccount" class="flex nav-item" data-tw-toggle="pill" data-tw-target="#add-account" type="button" role="tab" aria-controls="add-account" aria-selected="false">
                        <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i> Tambah Akun
                    </button>
                </li>
                <li id="change-password-tab" role="presentation" class="tab flex items-center mt-5">
                    <button id="btnChangePassword" class="flex nav-item" data-tw-toggle="pill" data-tw-target="#change-password" type="button" role="tab" aria-controls="change-password" aria-selected="false">
                        <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Ubah Password
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 2xl:col-span-9 tab-content">
        <!-- BEGIN: Display Information -->
        <div id="personal-information" class="tab-pane leading-relaxed box p-5 mt-5 active" role="tabpanel" aria-labelledby="personal-information-tab">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">Tampilkan Informasi</h2>
            </div>
            <div class="p-5">
                <form method="POST" action="{{route('admin.profil.update', Auth::user()->id)}}" enctype="multipart/form-data" class="flex flex-col-reverse xl:flex-row flex-col">
                    @csrf
                    @method('PUT')
                    <div class="flex-1 mt-6 xl:mt-0">
                        <div class="grid grid-cols-12 gap-x-5">
                            <div class="col-span-12 2xl:col-span-6">
                                <div>
                                    <label for="update-profile-form-1" class="form-label">Username</label>
                                    <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" value="{{ Auth::user()->username}}" disabled>
                                </div>
                                <div class="mt-3">
                                    <label for="update-profile-form-1" class="form-label">Nama</label>
                                    <input id="update-profile-form-1" name="name" type="text" class="form-control" placeholder="Input text" value="{{ Auth::user()->name}}">
                                </div>
                            </div>
                            <div class="col-span-12 2xl:col-span-6">
                                <div class="mt-3 2xl:mt-0">
                                    <div>
                                        <label for="update-profile-form-1" class="form-label">Site</label>
                                        <input id="update-profile-form-1" type="text" class="form-control" placeholder="Input text" value="{{ $site[0]->namasite}}" disabled>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div>
                                        <label for="update-profile-form-1" class="form-label">Posisi</label>
                                        <input id="update-profile-form-1" name="posisi" type="text" class="form-control" placeholder="Input text" value="{{ Auth::user()->posisi}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-20 mt-6">Save</button>
                    </div>
                    <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                        <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                            <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                <img name="gambar" id="preview-image-before-upload" class="rounded-md" alt="User Image" src="{{Auth::user()->getPhotoAttribute()}}">
                            </div>
                            <div class="mx-auto cursor-pointer relative mt-5">
                                <button type="button" class="btn btn-primary w-full">Change Photo</button>
                                <input name="foto" type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END: Display Information -->
        <!-- BEGIN: Add Account -->
        <div id="add-account" class="tab-pane leading-relaxed box p-5 mt-5" role="tabpanel" aria-labelledby="add-account-tab">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">Tambahkan Akun</h2>
            </div>
            <div class="p-5">
                <div class="flex flex-col-reverse xl:flex-row flex-col">
                    <form action="{{route('admin.register.store')}}" method="POST" enctype="multipart/form-data" class="flex-1 mt-6 xl:mt-0">
                        <div class="grid grid-cols-12 gap-x-5">
                            @csrf
                            <div class="col-span-12 2xl:col-span-6">
                                <div class="">
                                    <label for="update-profile-form-1" class="form-label">Foto</label>
                                    <input name="foto" id="update-profile-form-1" type="file" class="form-control p-1 border" placeholder="Input text">
                                </div>
                                <div class="">
                                    <label for="update-profile-form-1" class="form-label">Username</label>
                                    <input name="username" id="update-profile-form-1" type="text" class="form-control" placeholder="Input text">
                                </div>  
                            </div>
                            <div class="col-span-12 2xl:col-span-6">
                                <div class="mt-3">
                                    <label for="update-profile-form-1" class="form-label">Nama</label>
                                    <input name="name" id="update-profile-form-1" type="text" class="form-control" placeholder="Input text">
                                </div>
                                <div class="">
                                    <label for="update-profile-form-1" class="form-label">Password</label>
                                    <input name="password" id="update-profile-form-1" type="password" class="form-control" placeholder="Input text">
                                </div>
                            </div>
                            <div class="col-span-12 2xl:col-span-6">
                                <div class="mt-3">
                                    <div>
                                        <label for="update-profile-form-1" class="form-label">Site</label>
                                        <select name="kodesite" id="update-profile-form-1"  class="form-control" placeholder="Input text">
                                            <option disabled selected value="" class="form-control">Pilih</option>
                                            @foreach($newSite as $st)
                                            <option value="{{$st->kodesite}}" class="form-control">{{$st->namasite}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 2xl:col-span-6">
                            <div class="mt-3">
                                    <div>
                                        <label for="update-profile-form-1" class="form-label">Posisi</label>
                                        <select name="posisi" id="update-profile-form-1"  class="form-control" placeholder="Input text">
                                            <option disabled selected value="" class="form-control">Pilih</option>
                                            @foreach($posisi as $st)
                                            <option value="{{$st->jabatan}}" class="form-control">{{$st->jabatan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-20 mt-6">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- END: Add Account -->
        <!-- BEGIN: Change Password -->
        <div id="change-password" class="tab-pane leading-relaxed box p-5 mt-5" role="tabpanel" aria-labelledby="change-password-tab">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">Ubah Password</h2>
            </div>
            <div class="p-5">
                <div class="flex flex-col-reverse xl:flex-row flex-col">
                    <form action="{{route('admin.change-password.update')}}" method="POST" class="flex-1 mt-6 xl:mt-0">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-12 gap-x-5">
                            <div class=" col-span-12 ">
                                <label for="change-password-form-1" class="form-label">Password Lama</label>
                                <input name="password" id="change-password-form-1" type="password" class="form-control" placeholder="Input text">
                            </div>
                            <div class="mt-3 col-span-12 ">
                                <label for="change-password-form-2" class="form-label">Password Baru</label>
                                <input name="new_password" id="change-password-form-2" type="password" class="form-control" placeholder="Input text">
                            </div>
                            <div class="mt-3 col-span-12 ">
                                <label for="change-password-form-3" class="form-label">Konfirmasi Password Baru</label>
                                <input name="new_password_confirmation" id="change-password-form-3" type="password" class="form-control" placeholder="Input text">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-36 mt-6">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
        $('#photo').change(function(){
                    
            let reader = new FileReader();
        
            reader.onload = (e) => { 
        
                $('#preview-image-before-upload').attr('src', e.target.result); 
            }
        
            reader.readAsDataURL(this.files[0]); 
        
        });
    });
</script>
<script>
    $('btn#btnPersonalInformation [aria-selected="true"]').map(function(element) {
        $('.tab').removeClass('text-primary, font-medium');
        $('#personal-information-tab').addClass('text-primary, font-medium')
    })

    $('btn#btnAddAccount [aria-selected="true"]').map(function(element) {
        $('.tab').removeClass('text-primary, font-medium');
        $('#add-account-tab').addClass('text-primary, font-medium')
    })

    $('btn#btnChangePassword [aria-selected="true"]').map(function(element) {
        $('.tab').removeClass('text-primary, font-medium');
        $('#change-password-tab').addClass('text-primary, font-medium')
    })
</script>
@endsection