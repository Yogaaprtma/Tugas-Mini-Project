@extends('layouts.master')
@section('title', 'Profil Saya')

@section('content')
<div class="container text-white">
    <div class="row align-items-start mb-3 mt-4 ms-4"> 
        <div class="col-2 offset-1 align-self-start"> 
            {{-- Menampilkan foto profil --}}
            @if ($user->profile_picture)
                <img src="{{ asset($user->profile_picture) }}" alt="User Logo" class="rounded-circle me-3" style="width: 130px; height: 130px; object-fit: cover;">
            @else
                <img src="{{ asset('assets/profile.png') }}" alt="User Logo" class="rounded-circle me-3" style="width: 130px;">
            @endif
        </div>
        <div class="col-6 ms-5" style="margin-top: 15px;"> 
            <h5 class="card-title mb-0">{{ $user->username }}</h5>
            <div class="row mt-3">
                <div class="col-2 d-flex align-items-center">
                    <p class="text-light mb-0">{{ $user->postings_count }} posts</p>
                </div>
                <div class="col-3 d-flex align-items-center">
                    <a href="{{ route('detailProfile', ['id' => $user->id, 'tab' => 'followers']) }}" class="text-light text-decoration-none">
                        <p class="mb-0">{{ $user->followers_count }} followers</p>
                    </a>
                </div>
                <div class="col-7 d-flex align-items-center" style="margin-left: -20px;">
                    <a href="{{ route('detailProfile', ['id' => $user->id, 'tab' => 'following']) }}" class="text-light text-decoration-none">
                        <p class="mb-0">{{ $user->followings_count }} following</p>
                    </a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <p>{{ $user->nama }}</p>
                    <p style="margin-top: -10px; font-size: 13px">{{ $user->bio }}</p>
                </div>
            </div>
        </div>
        <div class="col-2 align-self-start" style="margin-top: 15px;">
            <div class="row align-items-start justify-content-center">
                <div class="col-auto">
                    <img src="{{ asset('assets/setting.png') }}" alt="Settings Logo" style="width: 24px;" data-bs-toggle="modal" data-bs-target="#confirmPasswordModal">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Password -->
<div class="modal fade" id="confirmPasswordModal" tabindex="-1" aria-labelledby="confirmPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-light border-light" style="background-color: black;">
            <div class="p-3 py-1"> <!-- Tambahkan div dengan kelas 'p-3' untuk memberikan padding -->
                <form method="POST" action="{{ route('konfirmasiPassword') }}">
                    @csrf
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <h5 class="modal-title mb-2" id="confirmPasswordModalLabel">Konfirmasi Password</h5>
                        <button type="button" class="btn-close text-light fw-bold" data-bs-dismiss="modal" aria-label="Close" style="margin-top: -12px">X</button>
                    </div>
                    <div>
                        <input type="password" class="form-control @error('confirmPassword') is-invalid @enderror bg-light" name="confirmPassword" placeholder="Masukkan password" value="{{ old('confirmPassword') }}">
                        @error('confirmPassword')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-link text-decoration-none text-light float-end">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="container mt-3">
    <div class="row">
        <div class="col">
            <div class="card no-border p-4 shadow-sm mb-4" style="background-color: black;">
                <!-- Konten card utama -->
                <div class="row">
                    @if ($user->postings !== null && $user->postings->isNotEmpty())
                        @foreach($user->postings as $posting)
                            <div class="col-md-4 mb-4"> <!-- Atur lebar card postingan di sini -->
                                <div class="card border-secondary text-light p-3 shadow-sm" style="background-color: black;">
                                    <!-- Isi Postingan -->
                                    <div class="row align-items-center mb-3">
                                        <div class="col-2">
                                            @if ($user->profile_picture)
                                                <img src="{{ asset($user->profile_picture) }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px; height: 40px">
                                            @else
                                                <img src="{{ asset('assets/profile.png') }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px;">
                                            @endif
                                        </div>
                                        <div class="col-8">
                                            <h5 class="card-title mb-0">{{ $posting->user->username }}</h5>
                                        </div>
                                        <div class="col-2">
                                            <img src="{{ asset('assets/white-bookmark.png') }}" alt="logo bookmark" class="me-3" style="width: 30px;">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p>{{ $posting->deskripsi }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <img src="{{ asset($posting->image) }}" alt="Post Image" class="img-fluid">
                                    </div>
                                    <div class="mb-3">
                                        <hr class="border-white border-2">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 d-flex align-items-center">
                                            <img src="{{ asset('assets/love.png') }}" alt="Love Icon" style="width: 20px;">
                                            <span class="ms-2">0 likes</span>
                                        </div>
                                        <div class="col-6 d-flex align-items-center">
                                            <img src="{{ asset('assets/comment.png') }}" alt="Comment Icon" style="width: 20px;">
                                            <span class="ms-2">0 comments</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-secondary text-center" style="margin-top: 180px">Belum ada postingan yang dapat ditampilkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<p class="text-center text-secondary">Copyright 2024</p>
@endsection