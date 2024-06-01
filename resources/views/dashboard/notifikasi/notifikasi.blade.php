@extends('layouts.master')

@section('title', 'Notifikasi')

@section('content')

<style>
    .notification-link {
        position: relative;
        display: inline-block;
        padding-bottom: 5px;
        transition: color 0.3s ease;
        color: white;
        text-decoration: none;
    }

    .notification-link::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 0;
        height: 3px;
        background-color: green;
        transition: width 0.3s ease, left 0.3s ease;
    }

    .notification-link.active::after {
        width: 150%;
        left: -25%; 
    }

    .notification-link:hover::after {
        width: 150%;
        left: -25%; 
    }

    .notification-link:active,
    .notification-link.active {
        animation: grow 0.3s ease forwards;
    }

    /* CSS untuk konten tab-pane */
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
    <div class="container-fluid text-center text-white mb-5 sticky-top" style="background-color: black;">
        <div class="mb-4">
            <p class="mt-3 fw-bold fs-5">Notifikasi</p>
        </div>
        <div class="d-inline-block mx-4">
            <a href="{{ route('notifikasi', ['tab' => 'all']) }}" class="notification-link text-decoration-none text-white {{ !isset($tab) || $tab === 'all' ? 'active' : '' }}" role="tab">Semua</a>
        </div>
        <div class="d-inline-block mx-4">
            <a href="{{ route('notifikasi', ['tab' => 'comments']) }}" class="notification-link text-decoration-none text-white {{ isset($tab) && $tab === 'comments' ? 'active' : '' }}" role="tab">Komentar</a>
        </div>
        <div class="d-inline-block mx-4">
            <a href="{{ route('notifikasi', ['tab' => 'likes']) }}" class="notification-link text-decoration-none text-white {{ isset($tab) && $tab === 'likes' ? 'active' : '' }}" role="tab">Disukai</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="tab-content mt-4" id="myTabContent">
                <!-- All Notifications tab -->
                <div class="tab-pane fade {{ !isset($tab) || $tab === 'all' ? 'show active' : '' }}" id="all" role="tabpanel">
                    <h5 class="text-light">Semua Notifikasi</h5>
                    @if ($notifications->isEmpty())
                        <p class="text-white mt-3">Anda belum memiliki notifikasi.</p>
                    @else
                        @foreach ($notifications as $notification)
                            <div class="card mb-3 d-flex" style="background-color: black; color: white">
                                <div class="card-body d-flex align-items-center">
                                    @if ($notification->sender)
                                        <img src="{{ $notification->sender->profile_picture }}" alt="Profil" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                        <h6 class="card-title me-3 mt-2">{{ $notification->sender->username }}</h6>
                                        <p class="card-text mt-3 me-5" style="padding-right: 100px">{{ $notification->message }}</p>
                                        @if ($notification->posting)
                                            <a href="{{ route('seePost', $notification->posting->id) }}" class="stretched-link">
                                                <img src="{{ $notification->posting->image }}" alt="Postingan" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                            </a>
                                        @endif
                                    @else
                                        <p>Notifikasi tidak valid.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        {{ $notifications->links() }}
                    @endif
                </div>

                <!-- Comments Notifications tab -->
                <div class="tab-pane fade {{ isset($tab) && $tab === 'comments' ? 'show active' : '' }}" id="comments" role="tabpanel">
                    <h5 class="text-light">Semua Notifikasi</h5>
                    @if ($commentsNotifications->isEmpty())
                        <p class="text-white mt-3">Anda belum memiliki notifikasi komentar.</p>
                    @else
                        @foreach ($commentsNotifications as $notification)
                            <div class="card mb-3 d-flex" style="background-color: black; color: white">
                                <div class="card-body d-flex">
                                    @if ($notification->sender)
                                        <img src="{{ $notification->sender->profile_picture }}" alt="Profil" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                        <h6 class="card-title me-3 mt-3">{{ $notification->sender->username }}</h6>
                                        <p class="card-text mt-3" style="padding-right: 120px">{{ $notification->message }}</p>
                                        @if ($notification->posting)
                                            <a href="{{ route('seePost', $notification->posting->id) }}" class="stretched-link">
                                                <img src="{{ $notification->posting->image }}" alt="Postingan" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                            </a>
                                        @endif
                                    @else
                                        <p>Notifikasi tidak valid.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        {{ $commentsNotifications->links() }}
                    @endif
                </div>

                <!-- Likes Notifications tab -->
                <div class="tab-pane fade {{ isset($tab) && $tab === 'likes' ? 'show active' : '' }}" id="likes" role="tabpanel">
                    <h5 class="text-light">Semua Notifikasi</h5>
                    @if ($likesNotifications->isEmpty())
                        <p class="text-white mt-3">Anda belum memiliki notifikasi suka.</p>
                    @else
                        @foreach ($likesNotifications as $notification)
                            <div class="card mb-3 d-flex" style="background-color: black; color: white">
                                <div class="card-body d-flex">
                                    @if ($notification->sender)
                                        <img src="{{ $notification->sender->profile_picture }}" alt="Profil" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                        <h6 class="card-title me-3 mt-3">{{ $notification->sender->username }}</h6>
                                        <p class="card-text mt-3" style="padding-right: 120px">{{ $notification->message }}</p>
                                        @if ($notification->posting)
                                            <a href="{{ route('seePost', $notification->posting->id) }}" class="stretched-link">
                                                <img src="{{ $notification->posting->image }}" alt="Postingan" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                            </a>
                                        @endif
                                    @else
                                        <p>Notifikasi tidak valid.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        {{ $likesNotifications->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
