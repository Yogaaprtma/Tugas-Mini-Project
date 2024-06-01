@extends('layouts.master')
@section('title', 'Beranda')

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

<div class="container">
    <!-- Navigation Tabs -->
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
            <div class="tab-content" id="myTabContent">
                <!-- For You tab -->
                <div class="tab-pane fade {{ !isset($tab) || $tab === 'foryou' ? 'show active' : '' }}" id="for-you" role="tabpanel">
                    @foreach($postings as $posting)
                        <div class="card border-secondary text-light p-3 shadow-sm mb-4" style="background-color: black">
                            <div class="row align-items-center mb-3">
                                <div class="col-2">
                                    @if ($posting->user->profile_picture)
                                        <img src="{{ asset($posting->user->profile_picture) }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px; height: 40px">
                                    @else
                                        <img src="{{ asset('assets/profile.png') }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px;">
                                    @endif
                                </div>
                                <div class="col-8">
                                    <h5 class="card-title mb-0">{{ $posting->user->username }}</h5>
                                </div>
                                <div class="col-2">
                                    <form action="{{ route('postBookmark', ['id' => $posting->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-decoration-none text-white" style="margin-top: -4px; font-size: 25px">
                                            @if ($posting->bookmarks->where('user_id', auth()->id())->isNotEmpty())
                                                <i class="fas fa-bookmark text-white"></i>
                                            @else
                                                <i class="far fa-bookmark text-white"></i>
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p>{{ $posting->deskripsi }}</p>
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('seePost', $posting->id) }}" class="text-decoration-none text-white">
                                    <img src="{{ asset($posting->image) }}" alt="Post Image" class="img-fluid">
                                </a>
                            </div>
                            <div>
                                <hr class="border-white border-2">
                            </div>
                            <div class="row">
                                <div class="col-3 d-flex align-items-center">
                                    <form action="{{ route('postLike', ['id' => $posting->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-decoration-none text-white" style="margin-top: -4px">
                                            @if ($posting->isLikedBy(auth()->id()))
                                                <i class="fas fa-heart like-icon" style="color: red"></i>
                                            @else
                                                <i class="far fa-heart like-icon"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <span style="margin-right: -20px; margin-top: -5px">{{ $posting->likes_count() }} Likes</span>
                                </div>
                                <div class="col-9 d-flex align-items-center"> 
                                    <a href="{{ route('seePost', $posting->id) }}" class="text-decoration-none text-white me-1" style="margin-top: -5px; margin-left: 50px;">
                                        <i class="far fa-comment"></i>
                                    </a>
                                    <span class="ms-2" style="margin-right: -20px; margin-top: -5px">{{ $posting->comments()->count() }} Comments</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Following tab -->
                <div class="tab-pane fade {{ isset($tab) && $tab === 'following' ? 'show active' : '' }}" id="following" role="tabpanel">
                    @foreach($postings as $posting)
                        <div class="card border-secondary text-light p-3 shadow-sm mb-4" style="background-color: black">
                            <div class="row align-items-center mb-3">
                                <div class="col-2">
                                    @if ($posting->user->profile_picture)
                                        <img src="{{ asset($posting->user->profile_picture) }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px; height: 40px">
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
                                <a href="{{ route('seePost', $posting->id) }}" class="text-decoration-none text-white">
                                    <img src="{{ asset($posting->image) }}" alt="Post Image" class="img-fluid">
                                </a>
                            </div>
                            <div class="mb-3">
                                <hr class="border-white border-2">
                            </div>
                            <div class="row mb-3">
                                <div class="col-3 d-flex align-items-center">
                                    <form action="{{ route('postLike', ['id' => $posting->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-decoration-none text-white">
                                            @if ($posting->isLikedBy(auth()->id()))
                                                <i class="fas fa-heart like-icon" style="color: red"></i>
                                            @else
                                                <i class="far fa-heart like-icon"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <span style="margin-right: -20px; margin-top: -5px">{{ $posting->likes_count() }} likes</span>
                                </div>
                                <div class="col-9 d-flex align-items-center">
                                    <a href="{{ route('seePost', $posting->id) }}" class="text-decoration-none text-white" style="margin-top: -5px">
                                        <i class="far fa-comment"></i>
                                    </a>
                                    {{-- <span class="ms-3" style="margin-right: -20px; margin-top: -5px">0 comments</span> --}}
                                    <span class="ms-2" style="margin-right: -20px; margin-top: -5px">{{ $posting->comments()->count() }} Comments</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-5 ms-5">
            <div class="row ms-5">
                <div class="col ms-5" id="follow-content">
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
</div>
@endsection
