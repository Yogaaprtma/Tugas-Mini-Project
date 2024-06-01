@extends('layouts.master')

@section('title', 'Lihat Postingan')

@section('content')
    <div class="container">
        <div class="container-fluid text-center text-white mb-4" style="background-color: black;">
            <div>
                <img src="{{ asset('assets/logo-medsos.png') }}" alt="Logo" style="width: 40px;">
            </div>
        </div>
        <h5 class="text-white" style="margin-bottom: 30px">All Bookmarks</h5>
        <div class="row ms-5 g-5">
            @if ($bookmarkedPosts->isEmpty())
                <div class="col">
                    <p class="text-white">Kamu belum bookmark terhadap postingan</p>
                </div>
            @else
                @foreach($bookmarkedPosts as $posting)
                    @if ($posting->user) 
                        <div class="col-auto" style="margin-right: 80px"> 
                            <div class="card border-secondary text-light p-3 shadow-sm mb-2 posting-card" style="background-color: black; width: 200px;"> <!-- Mengurangi margin bottom card -->
                                <div class="d-flex align-items-center mb-3">
                                    <div class="col-4">
                                        @if ($posting->user->profile_picture)
                                            <img src="{{ asset($posting->user->profile_picture) }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                        @else
                                            <img src="{{ asset('assets/profile.png') }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px;">
                                        @endif
                                    </div>
                                    <div class="col-8" style="margin-left: 5px">
                                        <h5 class="card-title mb-0" style="font-size: 14px">{{ $posting->user->username }}</h5>
                                        <span style="font-size: 9px">{{ $posting->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('seePost', $posting->id) }}" class="text-decoration-none text-white">
                                        <img src="{{ asset($posting->image) }}" alt="Post Image" class="img-fluid">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col">
                            <p class="text-white">User not found for this post.</p>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection
