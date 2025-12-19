<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop Admin | Login</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email Address</label>
                    <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        <input type="email" class="form-control" id="loginEmail" placeholder="admin@example.com" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Password</label>
                    <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        <input type="password" class="form-control" id="loginPassword" placeholder="Enter your password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                    <a href="#" class="float-end text-decoration-none">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>
                <div class="text-center mb-3">
                    <span class="text-muted">Or sign in with</span>
                </div>
                <div class="d-grid gap-2 mb-4">
                    <button type="button" class="btn btn-outline-primary">
                        <i class="fab fa-google me-2"></i> Google
                    </button>
                    <button type="button" class="btn btn-outline-primary">
                        <i class="fab fa-microsoft me-2"></i> Microsoft
                    </button>
                </div>
            </form>
        </div>
        <div class="auth-footer">
            <p>Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a></p>
            <p class="mb-0"><a href="{{ route('home') }}" class="text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a></p>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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

        // Login form submission
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const email = document.getElementById('loginEmail').value;
                const password = document.getElementById('loginPassword').value;

                // Simple validation (in a real app, this would be handled by backend)
                if (email === 'admin@example.com' && password === 'admin123') {
                    // Redirect to dashboard
                    window.location.href = 'index.html';
                } else {
                    // Show error alert
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                            Invalid email or password. Try with admin@example.com / admin123
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;

                    // Insert alert before form
                    loginForm.parentNode.insertBefore(alertDiv, loginForm);

                    // Auto remove alert after 5 seconds
                    setTimeout(() => {
                        if (alertDiv.parentNode) {
                            alertDiv.remove();
                        }
                    }, 5000);
                }
            });
        }

        // Dark mode for login page
        const darkModePreference = localStorage.getItem('darkMode') === 'true';
        if (darkModePreference) {
            document.body.classList.add('dark-mode');
        }
    });
</script>
</body>
</html>
