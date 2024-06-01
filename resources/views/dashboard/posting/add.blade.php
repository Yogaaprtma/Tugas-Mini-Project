@extends('layouts.master')
@section('title', 'Posting')

@section('content')

    <style>
        @keyframes grow {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.3);
            }
            100% {
                transform: scale(1);
            }
        }

        .for-you-link,
        .following-link {
            position: relative;
            display: inline-block;
            padding-bottom: 5px;
            transition: color 0.3s ease;
        }

        .for-you-link::after,
        .following-link::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 3px;
            background-color: green;
            transition: width 0.3s ease, left 0.3s ease;
        }

        .for-you-link.active::after,
        .following-link.active::after {
            width: 150%;
            left: -25%; 
        }

        .for-you-link:active,
        .following-link:active,
        .for-you-link.active,
        .following-link.active {
            animation: grow 0.3s ease forwards;
        }

        #follow-content {
            position: fixed;
            max-width: 335px;
        }
    </style>

    <div class="container mt-3">

        @if (Session::get('error'))
            <div class="row">
                <div class="col-md-4 offset-4 mt-2 py-2 rounded bg-danger text-white fw-bold">
                    {{ Session::get('error') }}
                </div>
            </div>
        @endif

        <div class="container-fluid text-center text-white mb-5 sticky-top" style="background-color: black;">
            <div class="mb-4">
                <img src="{{ asset('assets/logo-medsos.png') }}" alt="Logo" style="width: 40px;">
            </div>
            <div class="d-inline-block me-5">
                <a href="{{ route('halamanBeranda') }}" class="for-you-link text-decoration-none text-white {{ !isset($tab) || $tab === 'foryou' ? 'active' : '' }}" role="tab">For You</a>
            </div>
            <div class="d-inline-block">
                <a href="{{ route('halamanFollowing') }}" class="following-link text-decoration-none text-white {{ isset($tab) && $tab === 'following' ? 'active' : '' }}" role="tab">Following</a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-secondary text-light p-3 shadow-sm" style="background-color: black">
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            @if ($user->profile_picture)
                                <img src="{{ asset($user->profile_picture) }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px; height: 40px">
                            @else
                                <img src="{{ asset('assets/profile.png') }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px;">
                            @endif
                        </div>
                        <div class="col text-center">
                            <h5 class="card-title mb-0">{{ $user->username }}</h5>
                        </div>
                        <div class="col-auto">
                            <p class="text-bold fs-4">...</p>
                        </div>
                    </div>
                    <form action="{{ route('tambahPostinganStore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control border-0 @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="1" placeholder="Deskripsi Postingan" style="background-color: black">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="image" id="image-label" class="border border-secondary text-light" style="background-color: black; width: 390px; height: 220px; text-align: center; display: flex; justify-content: center; align-items: center; cursor: pointer;">
                                <img id="image-preview" src="#" alt="Image Preview" style="max-width: 100%; max-height: 100%; display: none;">
                                <span id="image-placeholder" class="position-absolute">Pilih Gambar</span>
                                <input type="file" class="form-control-file d-none @error('image') is-invalid @enderror" name="image" id="image">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
                        </div>
                        <div class="mb-3">
                            <hr class="border-white border-2">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn text-light p-0" style="width: 90px; height: 30px; background-color: darkcyan">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            var image = document.getElementById('image').files[0];
            var imagePreview = document.getElementById('image-preview');
            var imagePlaceholder = document.getElementById('image-placeholder');
            var imageLabel = document.getElementById('image-label');
    
            if (image) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    imagePlaceholder.style.display = 'none';
    
                    var img = new Image();
                    img.onload = function() {
                        // Set the dimensions of the label to match the image dimensions
                        var widthRatio = 400 / img.width;
                        var heightRatio = 520 / img.height;
                        var maxRatio = Math.min(widthRatio, heightRatio);
    
                        var width = img.width * maxRatio;
                        var height = img.height * maxRatio;
    
                        imageLabel.style.width = width + 'px';
                        imageLabel.style.height = height + 'px';
                    };
                    img.src = e.target.result;
                }
                reader.readAsDataURL(image);
            } else {
                imagePreview.style.display = 'none';
                imagePlaceholder.style.display = 'block';
                imageLabel.style.height = '220px'; // Reset height of label
                imageLabel.style.width = '390px'; // Reset width of label
            }
        });
    </script>
@endsection