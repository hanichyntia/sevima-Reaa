<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin - 5 Minute School</title>
    
    <!-- CDN Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- External Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style-register.css') }}">
</head>
<body>

<div class="main-card">
    <div class="row g-0">
        <!-- Banner Kiri -->
        <div class="col-lg-5 col-md-5 left-banner d-none d-md-flex">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-3 fw-bold">Reaa</span>
                </div>
                <div class="logo-sub">Study Online. Learn Online</div>
                
                <h2 class="banner-heading">Learn From World's<br>Best Instructors<br>Around The World.</h2>
            </div>
            
            
        </div>

        <!-- Form Kanan -->
        <div class="col-lg-7 col-md-7 right-content">
            <div class="text-end mb-3">
                <span class="lang-dropdown">English(USA) <i class="fas fa-chevron-down ms-1"></i></span>
            </div>

            <h3 class="form-title">Create Account</h3>

            {{-- Pesan Sukses / Session Alert --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.register.store') }}" method="POST">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <input type="text" 
                           class="form-control custom-input @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Full Name" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <input type="email" 
                           class="form-control custom-input @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Email Address" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4 password-container">
                    <input type="password" 
                           class="form-control custom-input @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Password" 
                           required>
                    <i class="far fa-eye-slash toggle-password" id="togglePassword"></i>
                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-3 password-container">
                    <input type="password" 
                           class="form-control custom-input" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Confirm Password" 
                           required>
                </div>

                <!-- Checkbox Terms & Policy -->
                <div class="mb-4 form-check d-flex align-items-center gap-2 ps-0">
                    <input type="checkbox" class="form-check-input ms-0" id="terms" required checked>
                    <label class="form-check-label terms-text" for="terms">
                        I agree to the <a href="#">terms of service</a> and <a href="#">privacy policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-signup w-100 mb-3">Sign Up</button>
            </form>

            <!-- Social Media Sign Up -->
            <div class="divider-text">
                <span>Or Sign Up With</span>
            </div>

            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="#" class="social-btn text-danger"><i class="fab fa-google"></i></a>
                <a href="#" class="social-btn text-primary"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-btn text-danger"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-btn text-info"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-btn text-primary"><i class="fab fa-linkedin-in"></i></a>
            </div>

            <!-- Login Link -->
            <div class="text-center footer-text">
                Already Have an account? <a href="#">Sign in</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>