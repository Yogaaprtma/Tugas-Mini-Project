<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh">
    <div class="card p-4 shadow-sm w-100" style="background-color: black; color: white;">
        <h2 class="text-center mb-4">Register</h2>
        
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
                <img src="{{ asset('assets/logo-medsos.png') }}" alt="Logo" class="img-fluid mt-5" style="width: 155px;">
            </div>
            <div class="col-md-8">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-6 px-0 pe-1">
                            <div class="mb-3">
                                <label for="username" class="form-label fw-bold">Username</label>
                                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"  placeholder="Masukkan username" required>
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 px-0">
                            <div class="mb-3">
                                <label for="nama" class="form-label fw-bold">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap" required>
                                @error('nama')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">E-Mail</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan akun e-mail" required>
                        @error('email')
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
                    <div class="mb-3">
                        <label for="konfirmasi_password" class="form-label fw-bold">Konfirmasi Password</label>
                        <span class="ms-2" id="toggleConfirmPassword">
                            <i class="far fa-eye eye-icon text-light" id="confirmEyeIcon" style="cursor: pointer;"></i>
                            <i class="fas fa-eye-slash eye-icon text-light hidden-eye" id="confirmEyeSlashIcon" style="cursor: pointer;"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Masukkan Confirm password" required>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-light fw-bold mt-3 mb-4" style="width: 140px">Register</button>
                    </div>
                </form>
                <p class="text-center mt-4">
                    Sudah punya akun? <a href="{{ route('loginPage') }}" class="text-light fw-bold">Login</a>
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
</body>
</html>
