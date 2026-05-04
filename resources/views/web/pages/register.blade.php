@extends('web.master')

@section('title', 'Register - E-Shop')

@section('page-content')
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
                            <form id="registerForm">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter your name">
                                    <label id="name-error" class="error text-danger" for="name" style="display: none"></label>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email">
                                    <label id="email-error" class="error text-danger" for="email" style="display: none"></label>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Enter your phone number">
                                    <label class="error" id="phone-error" for="phone" style="display: none"></label>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter your password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <label id="password-error" class="error text-danger" for="password" style="display: none"></label>
                                    <div class="invalid-feedback d-block"></div>
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
                                        <input type="password" name="password_confirmation" class="form-control" id="passwordConfirmation"  placeholder="Enter confirm password">
                                        <button class="btn btn-outline-secondary toggle-confirm-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <label id="passwordConfirmation-error" class="error text-danger" for="passwordConfirmation" style="display: none"></label>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" >
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                                        </label>
                                    </div>
                                    <label id="terms-error" class="error text-danger" for="terms" style="display: none"></label>
                                </div>

                                <button type="submit" name="submit" id="submit" class="btn btn-primary w-100 mb-3">
                                    <i class="fas fa-user-plus me-2"></i> Create Account
                                </button>

                                <div class="divider">
                                    <span>or sign up with</span>
                                </div>

                                <div class="social-login">
                                    <button type="button" class="btn-google" id="loginWithGoogleBtn">
                                        <i class="fab fa-google"></i> Google
                                    </button>
                                    <button type="button" class="btn-facebook" id="loginWithFacebookBtn">
                                        <i class="fab fa-facebook-f"></i> Facebook
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="auth-footer">
                            <p class="text-center">Already have an account? <a href="{{ route('login') }}">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('webJs')
    <script>
        $(document).ready(function (){
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

            // Register form submit
            $('#registerForm').validate({
                rules:{
                    name:{
                        required:true
                    },
                    email:{
                        required:true,
                        email:true
                    },
                    password:{
                        required:true
                    },
                    password_confirmation:{
                        required:true
                    },
                    terms:{
                        required:true
                    }
                },
                messages:{
                    name:{
                        required:"please enter your name",
                    },
                    email:{
                        required:"please enter your email",
                        email:"please enter valid email format"
                    },
                    password:{
                        required:"please enter password",
                    },
                    password_confirmation:{
                        required:"please enter confirm password",
                    },
                    term:{
                        required:"please read terms and privacy",
                    }
                },
                submitHandler:function (form, e){
                    e.preventDefault();
                    var formData = new FormData(form)
                    $.ajax({
                        url:'{{route('post-register')}}',
                        method:'POST',
                        dataType:'JSON',
                        data:formData,
                        processData:false,
                        contentType:false,
                        beforeSend:function (){
                            $('#submit').attr('disabled', true);
                        },
                        success:function (response){
                            window.location.href='{{route('login')}}';
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
                        },
                        complete(){
                            $('#submit').attr('disabled', false);
                        }
                    });
                }
            })
        });
    </script>
@endsection
