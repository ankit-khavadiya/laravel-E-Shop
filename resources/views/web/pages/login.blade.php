@extends('web.master')

@section('title', 'Login - E-Shop')

@section('page-content')
    <div class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card" data-aos="fade-up">
                        <div class="auth-header">
                            <h2>Welcome Back! 👋</h2>
                            <p>Sign in to your account</p>
                        </div>

                        <div class="auth-body">
                            <form method="POST" action="{{ route('login') }}" id="loginForm">
                                @csrf

                                <div class="form-group mb-3">
                                    <label class="form-label">Email Address</label>
                                    <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}" required autofocus>
                                    </div>
                                    @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">Remember me</label>
                                        </div>
                                        <a href="#" class="forgot-link">Forgot Password?</a>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                                </button>

                                <div class="divider">
                                    <span>or continue with</span>
                                </div>

                                <div class="social-login">
                                    <button type="button" class="btn-google">
                                        <i class="fab fa-google"></i> Google
                                    </button>
                                    <button type="button" class="btn-facebook">
                                        <i class="fab fa-facebook-f"></i> Facebook
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="auth-footer">
                            <p class="text-center">Don't have an account? <a href="{{ route('register') }}">Sign up now</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Toggle password visibility
        $('.toggle-password').click(function() {
            let password = $('#password');
            let type = password.attr('type') === 'password' ? 'text' : 'password';
            password.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
    </script>
@endsection
