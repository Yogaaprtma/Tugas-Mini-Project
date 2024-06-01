@extends('layouts.master')

@section('title', 'Detail Profile')

@section('content')
    <style>
        .profile-tab {
            position: relative;
            display: inline-block;
            padding-bottom: 5px;
            transition: color 0.3s ease;
            color: white;
            text-decoration: none;
        }

        .profile-tab::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 3px;
            background-color: green;
            transition: width 0.3s ease, left 0.3s ease;
        }

        .profile-tab.active::after {
            width: 150%;
            left: -25%; 
        }

        .profile-tab:active,
        .profile-tab.active {
            animation: grow 0.3s ease forwards;
        }

        .tab-pane .card.mb-3.d-flex {
            background-color: black;
            color: white;
            transition: background-color 0.3s ease;
        }

        .tab-pane .card.mb-3.d-flex:hover {
            background-color: darkslategrey;
        }
    </style>


    <div class="container">
        <!-- Navigation Tabs -->
        <a href="{{ route('MyProfile') }}" class="text-white d-inline-block fw-bold" style="text-decoration: none;">< Back</a>
        <div class="container-fluid text-center text-white mb-5 sticky-top" style="background-color: black;">
            <div class="mb-4">
                <p class="mt-3 fw-bold fs-5">{{ $user->username }}</p>
            </div>
            <div class="d-inline-block mx-4">
                <a href="{{ route('detailProfile', ['id' => $user->id, 'tab' => 'followers']) }}" class="profile-tab text-decoration-none text-white {{ !isset($tab) || $tab === 'followers' ? 'active' : '' }}" role="tab">Followers</a>
            </div>
            <div class="d-inline-block mx-4">
                <a href="{{ route('detailProfile', ['id' => $user->id, 'tab' => 'following']) }}" class="profile-tab text-decoration-none text-white {{ isset($tab) && $tab === 'following' ? 'active' : '' }}" role="tab">Following</a>
            </div>
        </div>

        <!-- Content for each tab -->
        <div class="row justify-content-center">
            <div class="tab-content mt-4" id="myTabContent">
                <!-- Followers Tab Content -->
                <div class="tab-pane fade {{ !isset($tab) || $tab === 'followers' ? 'show active' : '' }}" id="followers" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="text-white mb-4">Cari Followers</h4>
                            <!-- Search form -->
                            <div class="d-flex justify-content-center me-5">
                                <form action="" method="GET" class="d-flex w-100 mt-3 align-items-center">
                                    <input type="text" name="search" class="form-control me-2 border-secondary text-light" placeholder="Cari" style="background-color: black;" value="{{ old('search', $search ?? '') }}">
                                    <img src="{{ asset('assets/search.png') }}" alt="Search Icon" class="ms-2 mt-1" style="width: 30px; height: 30px; cursor: pointer;">
                                    <input type="hidden" name="tab" value="followers">
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6" style="color: black">
                            <h4 class="text-white">List All Followers</h4>
                            <div class="list-group">
                                @if (count($followers) > 0)
                                    @foreach($followers as $follower)
                                        <div class="d-flex align-items-center mb-3">
                                            <!-- Profile Picture -->
                                            @if ($follower->profile_picture)
                                                <img src="{{ asset($follower->profile_picture) }}" alt="Profile Picture" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/profile.png') }}" alt="Profile Picture" class="rounded-circle me-3" style="width: 40px;">
                                            @endif
                                            <!-- Username and Name -->
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-white mt-2" style="font-size: 14px;">{{ $follower->username }}</h6>
                                                <small class="text-secondary" style="font-size: 12px;">{{ $follower->nama }}</small>
                                            </div>
                                            <!-- Follow/Unfollow Button -->
                                            @if(Auth::check())
                                                @if(Auth::user()->followings && Auth::user()->followings->contains($follower->id))
                                                    <div class="ms-auto d-flex align-items-center" style="margin-right: 200px;">
                                                        <form action="{{ route('unfollowUser', $follower->id) }}" method="POST">
                                                            @csrf
                                                            {{-- @method('DELETE') --}}
                                                            <button type="submit" class="btn btn-sm text-danger" style="background-color: transparent; border: none; padding-left: 0; margin-left: 0;">Unfollow</button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="ms-auto d-flex align-items-center" style="margin-right: 200px;">
                                                        <form action="{{ route('followUser', $follower->id) }}" method="POST">
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
                                    <div class="d-flex align-items-center mb-3">
                                        <p class="text-white">User tidak ada.</p>
                                    </div>
                                @endif
                            </div> 
                        </div>
                    </div>
                </div>

                <!-- Following Tab Content -->
                <div class="tab-pane fade {{ isset($tab) && $tab === 'following' ? 'show active' : '' }}" id="following" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="text-white mb-4">Cari Followings</h4>
                            <!-- Search form -->
                            <div class="d-flex justify-content-center me-5">
                                <form action="" method="GET" class="d-flex w-100 mt-3 align-items-center">
                                    <input type="text" name="search" class="form-control me-2 border-secondary text-light" placeholder="Cari" style="background-color: black;" value="{{ old('search', $search ?? '') }}">
                                    <img src="{{ asset('assets/search.png') }}" alt="Search Icon" class="ms-2 mt-1" style="width: 30px; height: 30px; cursor: pointer;">
                                    <input type="hidden" name="tab" value="following">
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6" style="color: black">
                            <h4 class="text-white">List All Followings</h4>
                            <div class="list-group">
                                @if (count($followings) > 0)
                                    @foreach($followings as $following)
                                        <div class="d-flex align-items-center mb-3">
                                            <!-- Profile Picture -->
                                            @if ($following->profile_picture)
                                                <img src="{{ asset($following->profile_picture) }}" alt="Profile Picture" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/profile.png') }}" alt="Profile Picture" class="rounded-circle me-3" style="width: 40px;">
                                            @endif
                                            <!-- Username and Name -->
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-white mt-2" style="font-size: 14px;">{{ $following->username }}</h6>
                                                <small class="text-secondary" style="font-size: 12px;">{{ $following->nama }}</small>
                                            </div>
                                            <!-- Follow/Unfollow Button -->
                                            @if(Auth::check())
                                                @if(Auth::user()->followings && Auth::user()->followings->contains($following->id))
                                                    <div class="ms-auto d-flex align-items-center" style="margin-right: 200px;">
                                                        <form action="{{ route('unfollowUser', $following->id) }}" method="POST">
                                                            @csrf
                                                            {{-- @method('DELETE') --}}
                                                            <button type="submit" class="btn btn-sm text-danger" style="background-color: transparent; border: none; padding-left: 0; margin-left: 0;">Unfollow</button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="ms-auto d-flex align-items-center" style="margin-right: 200px;">
                                                        <form action="{{ route('followUser', $following->id) }}" method="POST">
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
                                    <div class="d-flex align-items-center mb-3">
                                        <p class="text-white">User tidak ada.</p>
                                    </div>
                                @endif
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
