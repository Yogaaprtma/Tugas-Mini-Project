<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('assets/logo-medsos.png') }}">
    <style>
        ::placeholder {
            color: gray !important;
        }
    
        textarea {
            color: white !important;
        }
    </style>
</head>
<body style="background-color: black">
    <header>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 d-flex flex-column text-white vh-100 p-3 sticky-top" style="width: 290px;">
                    <div class="d-flex align-items-center justify-content-between">
                        @guest
                            <img src="{{ asset('assets/logo-medsos.png') }}" alt="Logo" class="img-fluid mb-2" style="width: 50px;">
                            <div class="login-text me-4">
                                <p class="mt-3 mb-0">Silahkan Login Dahulu</p>
                                <p class="text-secondary">Ayo Login</p>
                            </div>
                        @endguest
                        
                        @auth
                            <a href="{{ route('MyProfile') }}" class="text-decoration-none text-white">
                                <div class="row align-items-center m-0">
                                    <div class="col-auto me-3 p-0">
                                        @if (Auth::user()->profile_picture)
                                            <img id="profile-picture-preview" src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile Picture Preview" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('assets/profile.png') }}" alt="User Logo" class="rounded-circle me-3" style="width: 40px;">
                                        @endif
                                    </div>
                                    <div class="col p-0">
                                        <div class="login-text">
                                            <p class="mt-3 mb-0">{{ Auth::user()->username }}</p>
                                            <p class="text-secondary">{{ Auth::user()->nama }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endauth
                    </div>
                    <hr class="border-white border-2">
                    <ul class="nav flex-column">
                        @auth
                            <li class="nav-item mb-2">
                                <a href="{{ route('halamanBeranda') }}" class="nav-link text-white d-flex align-items-center" data-bs-target="#for-you">
                                    <img src="{{ asset('assets/home.png') }}" alt="Home Icon" class="me-4" style="width: 24px;">
                                    Beranda
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('searchUsers') }}" class="nav-link text-white d-flex align-items-center">
                                    <img src="{{ asset('assets/search.png') }}" alt="Explore Icon" class="me-4" style="width: 24px;">
                                    Explore
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('notifikasi') }}" class="nav-link text-white d-flex align-items-center">
                                    <img src="{{ asset('assets/notifikasi.png') }}" alt="Explore Icon" class="me-4" style="width: 24px;">
                                    Notifikasi
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('tambahPostingan') }}" class="nav-link text-white d-flex align-items-center">
                                    <img src="{{ asset('assets/tambah.png') }}" alt="Explore Icon" class="me-4" style="width: 24px;">
                                    Posting
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('showBookmarks') }}" class="nav-link text-white d-flex align-items-center">
                                    <img src="{{ asset('assets/bookmark.png') }}" alt="Bookmark Icon" class="me-4" style="width: 24px;">
                                    Bookmark
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('logout') }}" class="nav-link text-white d-flex align-items-center">
                                    <img src="{{ asset('assets/back.png') }}" alt="Explore Icon" class="me-4" style="width: 24px;">
                                    Log Out
                                </a>
                            </li>
                        @else
                            <li class="nav-item mb-2">
                                <a href="{{ route('halamanBeranda') }}" class="nav-link text-white d-flex align-items-center">
                                    <img src="{{ asset('assets/home.png') }}" alt="Home Icon" class="me-4" style="width: 24px;">
                                    Beranda
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('searchUsers') }}" class="nav-link text-white d-flex align-items-center">
                                    <img src="{{ asset('assets/search.png') }}" alt="Explore Icon" class="me-4" style="width: 24px;">
                                    Explore
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('loginPage') }}" class="nav-link text-white d-flex align-items-center">
                                    <img src="{{ asset('assets/back.png') }}" alt="Login Icon" class="me-4" style="width: 24px;">
                                    Login
                                </a>
                            </li>
                        @endauth
                    </ul>
                </nav>
                <div class="col-md-9 p-3" style="background-color: black;">
                    @yield('content')
                </div>
            </div>
        </div>
    </header>
    
    @guest
        <footer class="footer fixed-bottom" style="background-color: darkcyan">
            <div class="container">
                <div class="row justify-content-between align-items-center py-4">
                    <div class="col-md-6">
                        <h5 class="mb-0 large text-white">Jangan ketinggalan berita terbaru</h5>
                        <small class="mb-0 mt-2 text-white">Login, untuk pengalaman yang baru</small>
                    </div>
                    <div class="col-md-6 text-center">
                        <a href="{{ route('loginPage') }}" class="btn border border-white text-white me-3 px-4 py-2 rounded-4">Login</a>
                        <a href="{{ route('registerPage') }}" class="btn btn-light text-dark fw-bold px-4 py-2 rounded-4">Register</a>
                    </div>
                </div>
            </div>
        </footer>
    @endguest
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-k0/VRDfl8rb5pAW+oSmzBfYtbjLxv6B0P5PC7FkFt7sNqSHwCRUHL5pVHmzQckfd" crossorigin="anonymous"></script>
</body>
</html>
