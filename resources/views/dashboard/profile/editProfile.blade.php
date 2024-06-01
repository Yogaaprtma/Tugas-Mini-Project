@extends('layouts.master')
@section('title', 'Edit Profil')

@section('content')
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card p-4 shadow-sm mb-4" style="background-color: black;">
                    <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <label for="profile_picture" id="profile-picture-label" class="border border-secondary text-light rounded-circle d-inline-block" style="background-color: black; width: 100px; height: 100px; text-align: center; cursor: pointer; position: relative; overflow: hidden;">
                                <img id="profile-picture-preview" src="{{ $user->profile_picture ? asset($user->profile_picture) : '#' }}" alt="Profile Picture Preview" style="width: 100%; height: 100%; object-fit: cover; display: {{ $user->profile_picture ? 'block' : 'none' }}; border-radius: 50%;">
                                <span id="profile-picture-placeholder" class="position-absolute top-50 start-50 translate-middle" style="display: {{ $user->profile_picture ? 'none' : 'block' }};">Pilih Gambar</span>
                                <input type="file" class="form-control-file d-none" name="profile_picture" id="profile_picture" onchange="previewProfilePicture(event)">
                            </label>
                            <h5 class="text-light mt-3">Edit Profil</h5>
                        </div>
                        <div class="mb-3 row">
                            <label for="username" class="col-sm-3 col-form-label text-light">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control border-secondary text-light" style="background-color: black" id="username" name="username" value="{{ Auth::user()->username }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nama" class="col-sm-3 col-form-label text-light">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control border-secondary text-light" style="background-color: black" id="nama" name="nama" value="{{ Auth::user()->nama }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="bio" class="col-sm-3 col-form-label text-light">Bio</label>
                            <div class="col-sm-9">
                                <textarea class="form-control border-secondary text-light" style="background-color: black" id="bio" name="bio" rows="3">{{ Auth::user()->bio }}</textarea>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn text-light" style="width: 110px; height: 35px; background-color: darkcyan">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewProfilePicture(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function() {
                const dataURL = reader.result;
                const previewImage = document.getElementById('profile-picture-preview');
                const placeholderText = document.getElementById('profile-picture-placeholder');

                previewImage.src = dataURL;
                previewImage.style.display = 'block';
                placeholderText.style.display = 'none';
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
