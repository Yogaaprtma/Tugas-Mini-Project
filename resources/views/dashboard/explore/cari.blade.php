@extends('layouts.master')
@section('title', 'Search')

@section('content')
    <div class="container">
        <div class="container-fluid text-center text-white mb-5 sticky-top" style="background-color: black; margin-left: -40px;">
            <div class="mb-4 me-5">
                <img src="{{ asset('assets/logo-medsos.png') }}" alt="Logo" style="width: 40px;">
            </div>
            <div class="d-flex justify-content-center me-5">
                <form action="" method="GET" class="d-flex w-50 mt-3">
                    <input type="text" name="search" class="form-control me-2 border-secondary text-light" placeholder="Cari User" style="background-color: black; width: 400px;" value="{{ old('search', $search ?? '') }}">
                    <img src="{{ asset('assets/search.png') }}" alt="Search Icon" class="ms-2 mt-1" style="width: 30px; height: 30px; cursor: pointer;">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 offset-md-1">
                @if (count($users) > 0)
                    <h4 class="text-white mb-4">Hasil pencarianmu</h4>
                    @foreach ($users as $user)
                        <div class="d-flex align-items-center mb-3">
                            @if ($user->profile_picture)
                                <img src="{{ asset($user->profile_picture) }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/profile.png') }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px;">
                            @endif
                            <div class="d-flex flex-column">
                                <h6 class="mb-0 text-white mt-2" style="font-size: 14px;">{{ $user->username }}</h6>
                                <small class="text-secondary" style="font-size: 12px;">{{ $user->nama }}</small>
                            </div>
                            @if(Auth::check())
                                @if(Auth::user()->followings && Auth::user()->followings->contains($user->id))
                                    <div class="ms-auto d-flex align-items-center" style="margin-right: 200px;">
                                        <form action="{{ route('unfollowUser', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm text-danger" style="background-color: transparent; border: none; padding-left: 0; margin-left: 0;">Unfollow</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="ms-auto d-flex align-items-center" style="margin-right: 200px;">
                                        <form action="{{ route('followUser', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm text-success" style="background-color: transparent; border: none; padding-left: 0; margin-left: 0;">Follow</button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <div class="ms-auto d-flex align-items-center" style="margin-right: 200px;">
                                    <a href="{{ route('loginPage') }}" class="btn btn-sm text-success" style="background-color: transparent; border: none; padding-left: 0; margin-left: 0;">Follow</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <h4 class="text-white mb-4">Tidak ada pencarian</h4>
                @endif
            </div>
            <div class="col-md-4">
                <div class="sticky-top" style="top: 5rem;">
                    <span class="text-white fw-bold fs-5">Siapa yang harus diikuti</span>
                    <small class="text-secondary d-block mt-2 mb-4">Orang yang mungkin anda kenal</small>
                    <hr class="border-white border-2 my-3">

                    @foreach($latestUsers as $user)
                            @php
                                // Inisialisasi array untuk menyimpan ID pengguna yang di-follow
                                $followedUsers = [];

                                // Jika pengguna sudah login, tambahkan ID pengguna yang di-follow ke dalam array
                                if(Auth::check()) {
                                    foreach(Auth::user()->followings as $following) {
                                        $followedUsers[] = $following->id;
                                    }
                                }
                            @endphp

                            {{-- Periksa apakah pengguna saat ini termasuk dalam daftar pengguna yang telah di-follow --}}
                            @if(!in_array($user->id, $followedUsers))
                                <div class="d-flex align-items-center mb-3">
                                    @if ($user->profile_picture)
                                        <img src="{{ asset($user->profile_picture) }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px; height: 40px">
                                    @else
                                        <img src="{{ asset('assets/profile.png') }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px;">
                                    @endif
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-white mt-2" style="font-size: 14px;">{{ $user->username }}</h6>
                                        <small class="text-secondary" style="font-size: 12px;">{{ $user->email }}</small>
                                    </div>
                                    <div class="ms-auto d-flex align-items-center">
                                        @if(Auth::check())
                                            <form action="{{ route('followUser', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm text-success" style="background-color: transparent; border: none;">Follow</button>
                                            </form>
                                        @else
                                            <a href="{{ route('loginPage') }}" class="btn btn-sm text-success" style="background-color: transparent; border: none;">Follow</a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    <hr class="border-white border-2 my-3">
                    <small class="text-secondary">Terms of Service Privacy Policy Cookie Policy Accessibility Ads info More © 2024 Sosmed</small>
                </div>
            </div>
        </div>
    </div>
@endsection
