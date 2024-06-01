@extends('layouts.master')
@section('title', 'Lihat Postingan')

@section('content')
    <div class="container">
        <div class="text-center">
            <img src="{{ asset('assets/logo-medsos.png') }}" alt="Logo" style="width: 40px;">
        </div>
        <a href="{{ route('halamanForyou') }}" class="text-white mb-3 d-inline-block fw-bold ms-5" style="text-decoration: none;">< Back</a>
        <div class="card border-secondary text-light p-3 shadow-sm mt-3 mb-4" style="background-color: black">
            <div class="row align-items-center mb-3">
                <div class="col-2">
                    @if ($posting->user->profile_picture)
                        <img src="{{ asset($posting->user->profile_picture) }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px; height: 40px">
                    @else
                        <img src="{{ asset('assets/profile.png') }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px;">
                    @endif
                </div>
                <div class="col-6" style="margin-left: -120px">
                    <h5 class="card-title mb-0">{{ $posting->user->username }}</h5>
                </div>
                <div class="col-4 mt-3" style="margin-left: -50px">
                    <h5>Komentar</h5>
                </div>
            </div>
            <div class="row">
                <!-- Postingan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <p>{{ $posting->deskripsi }}</p>
                    </div>
                    <div class="mb-3">
                        <img src="{{ asset($posting->image) }}" alt="Gambar Postingan" class="img-fluid">
                    </div>
                    <div class="mb-3">
                        <hr class="border-white border-2">
                    </div>
                </div>
                <!-- Form Komentar -->
                <div class="col-md-6">
                    <div class="row mb-3">
                        <!-- Komentar -->
                        <div class="mb-3" id="hasil-komentar">  
                            @if ($posting->comments->isEmpty())
                                <p class="text-secondary text-center">Belum ada komentar</p>
                            @else
                                @foreach ($posting->comments as $comment)
                                    <div class="mb-3 ms-3">
                                        <div class="d-flex align-items-center mb-2">
                                            @if ($comment->user->profile_picture)
                                                <img src="{{ asset($comment->user->profile_picture) }}" alt="Profile Picture Preview" style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%;">
                                            @else
                                                <img src="{{ asset('assets/profile.png') }}" alt="Foto Profil" class="rounded-circle me-2" style="width: 30px;">
                                            @endif
                                            <span class="ms-3">{{ $comment->user->username }}</span>
                                        </div>
                                        <p>{{ $comment->content }}</p>
                                        <div class="row">
                                            <div class="col">
                                                <form action="{{ route('postLike', ['id' => $comment->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-decoration-none text-white" style="font-size: 25px">
                                                        @if ($comment->likes->contains('user_id', auth()->id()))
                                                            <i class="fas fa-heart like-icon" style="color: darkcyan"></i>
                                                        @else
                                                            <i class="far fa-heart like-icon" style="color: darkcyan"></i>
                                                        @endif
                                                    </button>
                                                </form>
                                                {{ $comment->likes_count }} Likes
                                            </div>
                                            <div class="col" style="margin-left: 180px;">
                                                <form action="{{ route('hapusComment', $comment->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn text-danger">Hapus</button>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-link reply-btn text-success text-decoration-none">Reply</button>
                                            </div>
                                        </div>
                                        <div class="row mt-1 reply-form" style="display: none;">
                                            <div class="col">
                                                <form action="{{ route('replyComment', $comment->id) }}" method="POST">
                                                    @csrf
                                                    <div class="mb-2 d-flex justify-content-between align-items-center">
                                                        <textarea class="form-control" id="replyContent" name="replyContent" rows="1" placeholder="Balas Komentar " style="background-color: transparent; border: none; border-bottom: 1px solid #ffffff;"></textarea>
                                                        <button type="submit" class="btn text-success">Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Tampilkan balasan komentar -->
                                        @foreach ($comment->replies as $reply)
                                            <div class="ms-5 mt-2">
                                                <div class="d-flex align-items-center mb-2">
                                                    @if ($reply->user->profile_picture)
                                                        <img src="{{ asset($reply->user->profile_picture) }}" alt="Profile Picture Preview" style="width: 25px; height: 25px; object-fit: cover; border-radius: 50%;">
                                                    @else
                                                        <img src="{{ asset('assets/profile.png') }}" alt="Foto Profil" class="rounded-circle me-2" style="width: 25px;">
                                                    @endif
                                                    <span class="ms-3">{{ $reply->user->username }}</span>
                                                </div>
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <p>{{ $reply->content }}</p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <form action="{{ route('hapusReply', $reply->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn text-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <script>
                            const replyButtons = document.querySelectorAll('.reply-btn');
                            replyButtons.forEach(button => {
                                button.addEventListener('click', () => {
                                    const replyForm = button.parentElement.parentElement.nextElementSibling;
                                    if (replyForm.style.display === 'none') {
                                        replyForm.style.display = 'block';
                                    } else {
                                        replyForm.style.display = 'none';
                                    }
                                });
                            });
                        </script>
                    </div>
                    <hr class="border-white border-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <!-- Love -->
                        <div class="d-flex flex-column align-items-center">
                            <form action="{{ route('postLike', ['id' => $posting->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-decoration-none text-white" style="font-size: 25px">
                                    @if ($posting->isLikedBy(auth()->id()))
                                        <i class="fas fa-heart like-icon" style="color: darkcyan"></i>
                                    @else
                                        <i class="far fa-heart like-icon" style="color: darkcyan"></i>
                                    @endif
                                </button>
                            </form>
                            <span class="fw-bold" style="font-size: 12px; margin-top: -5px">{{ $posting->likes_count() }} like</span>
                            <span style="font-size: 9px; margin-right: -18px">{{ $posting->created_at->diffForHumans() }}</span>
                        </div>
                    
                        <!-- Comment -->
                        <div class="d-flex flex-column align-items-center">
                            <i class="far fa-comment" style="font-size: 25px; color: darkcyan; margin-top: -26px; margin-left: -235px"></i>
                        </div>
                    
                        <!-- Share -->
                        <div class="d-flex flex-column align-items-center">
                            <i class="far fa-paper-plane" style="font-size: 25px; color: darkcyan; margin-top: -26px; margin-left: -420px"></i>
                        </div>
                    
                        <!-- Bookmark -->
                        <div class="d-flex flex-column align-items-center">
                            <form action="{{ route('postBookmark', ['id' => $posting->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-decoration-none text-white" style="font-size: 25px">
                                    @if ($posting->bookmarks->where('user_id', auth()->id())->isNotEmpty())
                                        <i class="fas fa-bookmark" style="color: darkcyan;"></i>
                                    @else
                                        <i class="far fa-bookmark" style="color: darkcyan;"></i>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    
                    <div class="col-12">
                        <form action="{{ route('postComment', $posting->id) }}" method="POST">
                            @csrf
                            <div class="mb-3 mt-2 d-flex justify-content-between align-items-center">
                                <textarea class="form-control" id="comment" name="comment" rows="1" placeholder="Tambahkan Komentar " style="background-color: transparent; border: none; border-bottom: 1px solid #ffffff;"></textarea>
                                <button type="submit" class="btn text-light">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection