<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="{{ asset('assets/logo-medsos.png') }}">
    <style>
        .eye-icon {
            transition: opacity 0.3s ease-in-out;
        }
        .hidden-eye {
            opacity: 0;
        }
        .visible-eye {
            opacity: 1;
        }
    </style>
</head>
<body style="background-color: black; color: white;">

<div class="container d-flex justify-content-center align-items-center" style="height: 80vh">
    <div class="card p-4 shadow-sm w-75" style="background-color: black; color: white;">
        <h2 class="text-center mb-4">Login</h2>

        <!-- success message -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

         <!-- error message -->
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <div class="row">
            <div class="col-md-4 d-flex justify-content-center align-items-start">
                <img src="{{ asset('assets/logo-medsos.png') }}" alt="Logo" class="img-fluid mt-4" style="width: 155px;">
            </div>
            <div class="col-md-8">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">Username</label>
                        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"  placeholder="Masukkan username" required>
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <span class="ms-2" id="togglePassword">
                            <i class="far fa-eye eye-icon text-light" id="eyeIcon" style="cursor: pointer;"></i>
                            <i class="fas fa-eye-slash eye-icon text-light hidden-eye" id="eyeSlashIcon" style="cursor: pointer;"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-light fw-bold mt-3 mb-4" style="width: 140px">Login</button>
                    </div>
                </form>
                <p class="text-center mt-4">
                    Belum punya akun? <a href="{{ route('registerPage') }}" class="text-light fw-bold">Register</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');
    const eyeIconSlash = document.querySelector('#eyeIconSlash'); // Icon mata slash

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle visibility icon mata
        eyeIcon.classList.toggle('hidden-eye');
        eyeIconSlash.classList.toggle('hidden-eye');
    });

    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const konfirmasiPassword = document.querySelector('#password_confirmation');
    const confirmEyeIcon = document.querySelector('#confirmEyeIcon');
    const confirmEyeSlashIcon = document.querySelector('#confirmEyeSlashIcon');

    toggleConfirmPassword.addEventListener('click', function () {
        const type = konfirmasiPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        konfirmasiPassword.setAttribute('type', type);

        // Toggle visibility icon mata
        confirmEyeIcon.classList.toggle('hidden-eye');
        confirmEyeSlashIcon.classList.toggle('hidden-eye');
    });
</script>

<footer class="footer sticky-bottom mt-auto pt-5" style="background-color: white;">
    <div class="container">
        <div class="row pt-3 align-items-center">
            <div class="col-md-1 d-flex justify-content-center">
                <img src="{{ asset('assets/logo-medsos.png') }}" alt="Logo" class="img-fluid" style="width: 50px;">
            </div>
            <div class="col-md-9 d-flex justify-content-start">
                <h5 class="text-dark fw-bold ms-3">Tentang Kami</h5>
            </div>
            <div class="col-md-2 d-flex justify-content-start text-dark">
                <h5 class="fw-bold">Kontak</h5>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6"></div> 
            <div class="col-md-3 d-flex justify-content-start">
                <small class="text-dark">
                    <img src="{{ asset('assets/home-footer.png') }}" alt="Gambar" style="width: 20px; margin-right: 10px;">
                    Yoga Adi Pratama | Trangkil, Kab Pati 
                </small>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
