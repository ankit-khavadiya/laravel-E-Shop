<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop Admin | Login</title>

    <!-- Bootstrap 5 CSS -->
    <link href="{{asset('assets/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('assets/lib/fontawesome-7/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/lib/toastr/toastr.min.css')}}">

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
            <p>Sign in to your admin dashboard</p>
        </div>
        <div class="auth-body">
            <form id="loginForm">
                @csrf
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email Address</label>
                    <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        <input type="email" class="form-control" name="email" id="loginEmail" placeholder="admin@example.com">
                    </div>
                        <label id="loginEmail-error" class="error gt-s1error text-danger" for="loginEmail" style="display: none"></label>
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Password</label>
                    <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        <input type="password" class="form-control" name="password" id="loginPassword" placeholder="Enter your password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                        <label id="loginPassword-error" class="error gt-s1error text-danger" for="loginPassword" style="display: none"></label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                    <a href="#" class="float-end text-decoration-none">Forgot password?</a>
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100 mb-3 ">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>

            </form>
        </div>
        <div class="auth-footer">
            <p class="mb-0"><a href="{{ route('admin.home') }}" class="text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a></p>
        </div>
    </div>
</div>

<script src="{{asset('assets/lib/jquery/js/jquery-3.7.0.min.js') }}"></script>
<!-- Bootstrap JS Bundle -->
<script src="{{asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/lib/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/lib/toastr/toastr.min.js')}}"></script>
<!-- Custom JS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('loginPassword');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

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

        // Dark mode for login page
        const darkModePreference = localStorage.getItem('darkMode') === 'true';
        if (darkModePreference) {
            document.body.classList.add('dark-mode');
        }
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
          errorClass : "error gt-s1error text-danger",
          submitHandler:function (form){
              var formData = new FormData(form)
              $.ajax({
                 url:"{{route('admin.post-login')}}",
                 method: "POST",
                 dataType: "JSON",
                 data: formData,
                 processData:false,
                 contentType:false,
                 beforeSend:function (){
                     $('#loginSubmit').attr('disabled', true);
                 },
                 success:function (response){
                     window.location.href='{{route('admin.home')}}';
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
</body>
</html>
