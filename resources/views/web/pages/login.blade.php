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
                            <form id="loginForm">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email">
                                    </div>
                                    <label id="email-error" class="error text-danger" for="email" style="display: none"></label>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter your password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <label id="password-error" class="error text-danger" for="password" style="display: none"></label>
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

                                <button type="submit" name="submit" class="btn btn-primary w-100 mb-3" id="loginSubmit">
                                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                                </button>

                                <div class="divider">
                                    <span>or continue with</span>
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
                            <p class="text-center">Don't have an account? <a href="{{ route('register') }}">Register now</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('webJs')
    <script>
        // Toggle password visibility
        $('.toggle-password').click(function() {
            let password = $('#password');
            let type = password.attr('type') === 'password' ? 'text' : 'password';
            password.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });

        $(document).ready(function (){
            $('#loginForm').validate({
                rules:{
                    email:{ required:true, email:true },
                    password:{ required:true }
                },
                messages:{
                    email:{
                        required:"please enter email",
                        email:"please enter valid email format"
                    },
                    password:{
                        required:"please enter password",
                    }
                },
                submitHandler:function (form){
                    var formData = new FormData(form)
                    $.ajax({
                        url:"{{route('post-login')}}",
                        method: "POST",
                        dataType: "JSON",
                        data: formData,
                        processData:false,
                        contentType:false,
                        beforeSend:function (){
                            $('#loginSubmit').attr('disabled', true);
                        },
                        success:function (response){
                            window.location.href='{{route('home')}}';
                        },
                        error:function (xhr){
                            let res = xhr.responseJSON;

                            if(res?.errors){
                                if(res.errors.email){
                                    $('#loginEmail-error').html(res.errors.email[0]).show();
                                }
                                if(res.errors.password){
                                    $('#loginPassword-error').html(res.errors.password[0]).show();
                                }
                            }else if(res?.message){
                                toastr.error(res.message);
                            }
                        },
                        complete(){
                            $('#loginSubmit').attr('disabled', false);
                        }
                    });
                },
            });
        });
    </script>
@endsection
