<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop Admin | Register</title>

    <!-- Bootstrap 5 CSS -->
    <link href="{{asset('assets/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('assets/lib/fontawesome-7/css/all.min.css')}}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛒</text></svg>" type="image/x-icon">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2><i class="fas fa-shopping-bag me-2"></i>E-Shop Admin</h2>
            <p>Create your admin account</p>
        </div>
        <div class="auth-body">
            <form id="registerForm">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            <input type="text" name="name" class="form-control" id="firstName" placeholder="John" required>
                        </div>
                    </div>
{{--                    <div class="col-md-6 mb-3">--}}
{{--                        <label for="lastName" class="form-label">Last Name</label>--}}
{{--                        <div class="input-group">--}}
{{--                                <span class="input-group-text">--}}
{{--                                    <i class="fas fa-user"></i>--}}
{{--                                </span>--}}
{{--                            <input type="text" class="form-control" id="lastName" placeholder="Doe" required>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="mb-3">
                    <label for="registerEmail" class="form-label">Email Address</label>
                    <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        <input type="email" name="email" class="form-control" id="registerEmail" placeholder="john.doe@example.com" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="registerPassword" class="form-label">Password</label>
                    <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        <input type="password" name="password" class="form-control" id="registerPassword" placeholder="Create a password" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleRegisterPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-text">Must be at least 8 characters long</div>
                </div>
{{--                <div class="mb-3">--}}
{{--                    <label for="confirmPassword" class="form-label">Confirm Password</label>--}}
{{--                    <div class="input-group">--}}
{{--                            <span class="input-group-text">--}}
{{--                                <i class="fas fa-lock"></i>--}}
{{--                            </span>--}}
{{--                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password" required>--}}
{{--                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">--}}
{{--                            <i class="fas fa-eye"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="mb-3 form-check">--}}
{{--                    <input type="checkbox" class="form-check-input" id="agreeTerms" required>--}}
{{--                    <label class="form-check-label" for="agreeTerms">--}}
{{--                        I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>--}}
{{--                    </label>--}}
{{--                </div>--}}
                <button type="submit" name="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-user-plus me-2"></i> Create Account
                </button>
{{--                <div class="text-center mb-3">--}}
{{--                    <span class="text-muted">Or sign up with</span>--}}
{{--                </div>--}}
{{--                <div class="d-grid gap-2 mb-4">--}}
{{--                    <button type="button" class="btn btn-outline-primary">--}}
{{--                        <i class="fab fa-google me-2"></i> Google--}}
{{--                    </button>--}}
{{--                    <button type="button" class="btn btn-outline-primary">--}}
{{--                        <i class="fab fa-microsoft me-2"></i> Microsoft--}}
{{--                    </button>--}}
{{--                </div>--}}
            </form>
        </div>
        <div class="auth-footer">
{{--            <p>Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a></p>--}}
            <p class="mb-0"><a href="{{route('admin.home')}}" class="text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a></p>
        </div>
    </div>
</div>

<script src="{{asset('assets/lib/jquery/js/jquery-3.7.0.min.js') }}"></script>

<!-- Bootstrap JS Bundle -->
<script src="{{asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('assets/lib/jquery-validation/jquery.validate.js')}}"></script>

<!-- Custom JS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility for register password
        const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
        const registerPasswordInput = document.getElementById('registerPassword');

        if (toggleRegisterPassword && registerPasswordInput) {
            toggleRegisterPassword.addEventListener('click', function() {
                const type = registerPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                registerPasswordInput.setAttribute('type', type);

                // Toggle eye icon
                const icon = this.querySelector('i');
                if (type === 'password') {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        }

        // Toggle password visibility for confirm password
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');

        if (toggleConfirmPassword && confirmPasswordInput) {
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);

                // Toggle eye icon
                const icon = this.querySelector('i');
                if (type === 'password') {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        }
        // Dark mode for register page
        const darkModePreference = localStorage.getItem('darkMode') === 'true';
        if (darkModePreference) {
            document.body.classList.add('dark-mode');
        }
    });

    $(document).ready(function (){

        // insert data
        $('#registerForm').validate({

            submitHandler:function (form){
                var formData = new FormData(form)

                $.ajax({
                    url:'{{route('admin.post-register')}}',
                    method:'POST',
                    dataType:'JSON',
                    data:formData,
                    processData:false,
                    contentType:false,
                    success:function (response){
                        if(response.success){
                            window.location.href='{{route('admin.login')}}';
                        }
                    },
                    error: function (xhr) {
                        var errorMessage = JSON.parse(xhr.responseText);
                        if (errorMessage.error) {
                            if (errorMessage.error.name) {
                                $('#name-error').addClass('text-danger').text(errorMessage.error.name[0]).show();
                            }
                            if (errorMessage.error.email) {
                                $('#email-error').addClass('text-danger').text(errorMessage.error.email[0]).show();
                            }
                            if (errorMessage.error.password) {
                                $('#password-error').addClass('text-danger').text(errorMessage.error.password[0]).show();
                            }
                        } else if (errorMessage.message) {
                            if (errorMessage.code === 500) {
                                alert(errorMessage.message);
                            } else {
                                $('#message-error').html(errorMessage.message).show();
                            }
                        }
                    }
                });
            }
        })
    });
</script>
</body>
</html>
