@extends('web.master')

@section('title', 'Register - E-Shop')

@section('content')
    <div class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="auth-card" data-aos="fade-up">
                        <div class="auth-header">
                            <h2>Create Account 🚀</h2>
                            <p>Join us and start shopping!</p>
                        </div>

                        <div class="auth-body">
                            <form method="POST" action="{{ route('register') }}" id="registerForm">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                               value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                               value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="password-strength mt-2">
                                        <small class="text-muted">Password strength:</small>
                                        <div class="progress mt-1" style="height: 4px;">
                                            <div class="progress-bar" id="strengthBar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" class="form-control" id="passwordConfirmation" required>
                                        <button class="btn btn-outline-secondary toggle-confirm-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div id="passwordMatchMsg" class="mt-2"></div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-3">
                                    <i class="fas fa-user-plus me-2"></i> Create Account
                                </button>

                                <div class="divider">
                                    <span>or sign up with</span>
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
                            <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Password strength checker
        $('#password').on('input', function() {
            let password = $(this).val();
            let strength = 0;

            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]/)) strength += 25;
            if (password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 25;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 25;

            if (strength > 100) strength = 100;

            $('#strengthBar').css('width', strength + '%');

            if (strength <= 25) {
                $('#strengthBar').removeClass('bg-success bg-warning').addClass('bg-danger');
            } else if (strength <= 50) {
                $('#strengthBar').removeClass('bg-success bg-danger').addClass('bg-warning');
            } else {
                $('#strengthBar').removeClass('bg-danger bg-warning').addClass('bg-success');
            }

            checkPasswordMatch();
        });

        // Check password match
        function checkPasswordMatch() {
            let password = $('#password').val();
            let confirm = $('#passwordConfirmation').val();

            if (confirm.length > 0) {
                if (password === confirm) {
                    $('#passwordMatchMsg').html('<small class="text-success"><i class="fas fa-check-circle"></i> Passwords match</small>');
                } else {
                    $('#passwordMatchMsg').html('<small class="text-danger"><i class="fas fa-times-circle"></i> Passwords do not match</small>');
                }
            } else {
                $('#passwordMatchMsg').html('');
            }
        }

        $('#passwordConfirmation').on('input', checkPasswordMatch);

        // Toggle password visibility
        $('.toggle-password, .toggle-confirm-password').click(function() {
            let target = $(this).prev('input');
            let type = target.attr('type') === 'password' ? 'text' : 'password';
            target.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
    </script>
@endsection
