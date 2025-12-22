@extends('admin.master')
@section('title','Home')
@section('page-content')
<!-- Admin Profile Page -->
<section id="admin-profile" class="page">
    <div class="page-header">
        <h2>Admin Profile</h2>
        <p class="text-muted">Manage your admin profile and security settings.</p>
    </div>

    <div class="row">
        <!-- Left Column - Profile Information -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Information</h5>
                </div>
                <div class="card-body text-center">
                    <div class="profile-image-container mb-4">
                        <div class="profile-image-wrapper">
                            <img src="{{ $adminDetails->profile_image ? asset('upload/' . $adminDetails->profile_image) : asset('assets/images/user.png') }}" alt="Admin User" class="profile-image rounded-circle" id="profileImage">

                            <div class="profile-image-overlay" onclick="document.getElementById('profileImageInput').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>

                        <form id="imageUploadForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $adminDetails->id }}">
                            <input type="file" name="image" id="profileImageInput" accept="image/*" class="d-none">
                            <label id="adminProfileImage-error" class="error gt-s1error text-danger" for="adminProfileImage" style="display: none"></label>
                        </form>
                    </div>

                    <h4 class="mb-1" id="profileNameDisplay">{{$adminDetails->name}}</h4>
                    <p class="text-muted mb-3">Super Administrator</p>

                    <div class="profile-stats mb-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <h5 class="mb-0">24</h5>
                                <small class="text-muted">Today</small>
                            </div>
                            <div class="col-4">
                                <h5 class="mb-0">128</h5>
                                <small class="text-muted">This Week</small>
                            </div>
                            <div class="col-4">
                                <h5 class="mb-0">5.4k</h5>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                    </div>

                    <div class="profile-details">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Status:</span>
                            <span class="badge bg-success">Active</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Last Login:</span>
                            <span>Today, 10:30 AM</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Joined:</span>
                            <span>Jan 15, 2023</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Role:</span>
                            <span class="badge bg-primary">Super Admin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        <div class="activity-item">
                            <div class="activity-icon bg-primary">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="activity-content">
                                <h6 class="mb-0">Logged in</h6>
                                <small class="text-muted">2 minutes ago</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-success">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="activity-content">
                                <h6 class="mb-0">Processed order #ORD-7841</h6>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-info">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="activity-content">
                                <h6 class="mb-0">Added new product</h6>
                                <small class="text-muted">3 hours ago</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-warning">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="activity-content">
                                <h6 class="mb-0">Updated settings</h6>
                                <small class="text-muted">Yesterday</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Forms -->
        <div class="col-lg-8">
            <!-- Personal Information Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <form id="personalInfoForm">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" value="{{$adminDetails->id}}">
                            <div class="col-md-6 mb-3">
                                <label for="adminName" class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" id="adminName" value="{{$adminDetails->name}}">
                                <label id="adminName-error" class="error gt-s1error text-danger" for="adminName" style="display: none"></label>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="adminEmail" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" name="email" id="adminEmail" value="{{$adminDetails->email}}">
                                <label id="adminEmail-error" class="error gt-s1error text-danger" for="adminEmail" style="display: none"></label>

                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="adminPhone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" id="adminPhone" value="{{$adminDetails->phone}}">
                                <label id="adminPhone-error" class="error gt-s1error text-danger" for="adminPhone" style="display: none"></label>

                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="adminAddress" class="form-label">Address</label>
                                <textarea class="form-control" name="address" id="adminAddress" rows="2">{{$adminDetails->address}}</textarea>
                                <label id="adminAddress-error" class="error gt-s1error text-danger" for="adminAddress" style="display: none"></label>

                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="adminCountry" class="form-label">Country</label>
                                <select class="form-select" name="country" id="adminCountry">
                                    <option value="{{$adminDetails->country}}" selected>{{$adminDetails->country}}</option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Australia">Australia</option>
                                    <option value="India">India</option>
                                </select>
                                <label id="adminCountry-error" class="error gt-s1error text-danger" for="adminCountry" style="display: none"></label>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="adminTimezone" class="form-label">Timezone</label>
                                <select class="form-select" id="adminTimezone">
                                    <option value="UTC-5" selected>Eastern Time (UTC-5)</option>
                                    <option value="UTC-8">Pacific Time (UTC-8)</option>
                                    <option value="UTC+0">GMT (UTC+0)</option>
                                    <option value="UTC+1">CET (UTC+1)</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="submit" id="infoUpdate" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Information
                        </button>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form id="changePasswordForm">
                        @csrf
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password *</label>
                            <div class="input-group">
                                <input type="password" name="currentPassword" class="form-control" id="currentPassword" placeholder="Enter current password">
                                <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <label id="adminCurrentPassword-error" class="error text-danger" for="adminCurrentPassword" style="display: none"></label>
                        </div>

                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password *</label>
                            <div class="input-group">
                                <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="Enter new password">
                                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <label id="adminNewPassword-error" class="error text-danger" for="adminNewPassword" style="display: none"></label>

                            <div class="password-strength mt-2">
                                <small class="text-muted">Password strength:</small>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-danger" id="passwordStrengthBar" style="width: 0%"></div>
                                </div>
                                <small id="passwordStrengthText" class="text-muted">Enter a password</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="confirmPassword" class="form-label">Confirm New Password *</label>
                            <div class="input-group">
                                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="passwordMatchMessage" class="mt-2"></div>
                            <label id="adminConfirmPassword-error" class="error text-danger" for="adminConfirmPassword" style="display: none"></label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-primary" id="changePasswordBtn">
                                <i class="fas fa-key me-1"></i> Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Security Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="twoFactorAuth" checked>
                                    <label class="form-check-label" for="twoFactorAuth">Two-Factor Authentication</label>
                                </div>
                                <small class="text-muted">Extra security layer for your account</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="loginAlerts" checked>
                                    <label class="form-check-label" for="loginAlerts">Login Alerts</label>
                                </div>
                                <small class="text-muted">Get notified of new logins</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="sessionTimeout" checked>
                                    <label class="form-check-label" for="sessionTimeout">Auto Logout (30 min)</label>
                                </div>
                                <small class="text-muted">Logout after inactivity</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="trustedDevices">
                                    <label class="form-check-label" for="trustedDevices">Remember This Device</label>
                                </div>
                                <small class="text-muted">Skip 2FA on this device</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-outline-primary me-2" onclick="viewLoginHistory()">
                            <i class="fas fa-history me-1"></i> View Login History
                        </button>
                        <button class="btn btn-outline-danger" onclick="logoutAllSessions()">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout All Sessions
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', initAdminProfile);

        function initAdminProfile() {
            setupPasswordToggles();
            setupPasswordStrength();
            // setupChangePasswordForm();
            setupSecuritySettings();
        }

        /* ---------------- PASSWORD TOGGLE ---------------- */
        function setupPasswordToggles() {
            bindToggle('toggleCurrentPassword', 'currentPassword');
            bindToggle('toggleNewPassword', 'newPassword');
            bindToggle('toggleConfirmPassword', 'confirmPassword');
        }

        function bindToggle(btnId, inputId) {
            const btn = document.getElementById(btnId);
            const input = document.getElementById(inputId);
            if (!btn || !input) return;

            btn.addEventListener('click', () => {
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.querySelector('i').className = `fas fa-eye${show ? '-slash' : ''}`;
            });
        }

        /* ---------------- PASSWORD STRENGTH ---------------- */
        function setupPasswordStrength() {
            const newPass = document.getElementById('newPassword');
            const confirmPass = document.getElementById('confirmPassword');

            newPass?.addEventListener('input', () => {
                updateStrength(newPass.value);
                checkMatch();
            });

            confirmPass?.addEventListener('input', checkMatch);
        }

        function passwordScore(pwd) {
            let score = 0;
            if (pwd.length >= 8) score++;
            if (/[A-Z]/.test(pwd)) score++;
            if (/[a-z]/.test(pwd)) score++;
            if (/\d/.test(pwd)) score++;
            if (/[^A-Za-z0-9]/.test(pwd)) score++;
            return score;
        }

        function updateStrength(pwd) {
            const bar = document.getElementById('passwordStrengthBar');
            const text = document.getElementById('passwordStrengthText');
            if (!bar || !text) return;

            if (!pwd) {
                bar.style.width = '0%';
                bar.className = 'progress-bar bg-danger';
                text.textContent = 'Enter a password';
                return;
            }

            const score = passwordScore(pwd);
            const levels = ['Weak', 'Fair', 'Good', 'Strong'];
            const colors = ['bg-danger', 'bg-warning', 'bg-info', 'bg-success'];

            bar.style.width = `${score * 20}%`;
            bar.className = `progress-bar ${colors[Math.min(score - 1, 3)]}`;
            text.textContent = levels[Math.min(score - 1, 3)];
        }

        function checkMatch() {
            const msg = document.getElementById('passwordMatchMessage');
            const p1 = document.getElementById('newPassword')?.value;
            const p2 = document.getElementById('confirmPassword')?.value;
            if (!msg) return;

            msg.textContent = p1 && p2 ? (p1 === p2 ? '✓ Passwords match' : '✗ Passwords do not match') : '';
            msg.className = `mt-2 ${p1 === p2 ? 'text-success' : 'text-danger'}`;
        }

        /* ---------------- CHANGE PASSWORD FORM ---------------- */
        // function setupChangePasswordForm() {
        //     const form = document.getElementById('changePasswordForm');
        //     if (!form) return;
        //
        //     form.addEventListener('submit', e => {
        //         e.preventDefault();
        //
        //         const cur = currentPassword.value;
        //         const next = newPassword.value;
        //         const conf = confirmPassword.value;
        //
        //         if (!cur || !next) return showAlert('All fields are required', 'danger');
        //         if (next !== conf) return showAlert('Passwords do not match', 'danger');
        //         if (passwordScore(next) < 3) return showAlert('Password too weak', 'warning');
        //
        //         toggleBtn(true);
        //
        //         setTimeout(() => {
        //             form.reset();
        //             updateStrength('');
        //             passwordMatchMessage.textContent = '';
        //             toggleBtn(false);
        //             showAlert('Password changed successfully!', 'success');
        //         }, 1200);
        //     });
        // }

        function toggleBtn(loading) {
            const btn = document.getElementById('changePasswordBtn');
            if (!btn) return;
            btn.disabled = loading;
            btn.innerHTML = loading
                ? '<i class="fas fa-spinner fa-spin"></i> Changing...'
                : 'Change Password';
        }

        /* ---------------- SECURITY SETTINGS ---------------- */
        function setupSecuritySettings() {
            ['twoFactorAuth', 'loginAlerts', 'sessionTimeout', 'trustedDevices'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;

                el.checked = localStorage.getItem(`admin_${id}`) === 'true';
                el.addEventListener('change', () => {
                    localStorage.setItem(`admin_${id}`, el.checked);
                    showAlert(`${el.labels[0].innerText} ${el.checked ? 'enabled' : 'disabled'}`, 'info');
                });
            });
        }

        /* ---------------- ALERT HELPER ---------------- */
        function showAlert(msg, type) {
            document.querySelectorAll('.alert').forEach(a => a.remove());
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show mt-3`;
            alert.innerHTML = `${msg} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
            document.querySelector('.page-header')?.after(alert);
            setTimeout(() => alert.remove(), 5000);
        }
    </script>

    <script>
        $(document).ready(function (){
            $('#personalInfoForm').validate({
                rules:{
                    name:{ required:true },
                    email:{ required:true, email:true }
                },
                messages:{
                    name:{
                        required:"please enter name",
                    },
                    email:{
                        required:"please enter email",
                        email:"please enter valid email format"
                    }
                },
                errorClass : "error gt-s1error",
                submitHandler:function (form, e) {
                    e.preventDefault();
                    var formData = new FormData(form);
                    $.ajax({
                       url:"{{route('post-admin-profile')}}",
                       method:"POST",
                       dataType:"JSON",
                       data: formData,
                       processData:false,
                       contentType:false,
                        beforeSend:function (){
                            $('#infoUpdate').attr('disabled', true);
                        },
                        success:function (response){
                            toastr.success(response.message);
                            $('#profileNameDisplay').html(response.data);
                            $('#headerprofileNameDisplay').html(response.data);
                        },
                        error: function (xhr) {
                            let res = xhr.responseJSON;
                            console.log(res);
                            if (res?.error) {
                                if (res.error.id) {
                                    toastr.error(res.error.id[0]);
                                }
                                if (res.error.name) {
                                    $('#adminName-error').html(res.error.name[0]).show();
                                }
                                if (res.error.email) {
                                    $('#adminEmail-error').html(res.error.email[0]).show();
                                }
                                if (res.error.phone) {
                                    $('#adminPhone-error').html(res.error.phone[0]).show();
                                }
                                if (res.error.address) {
                                    $('#adminAddress-error').html(res.error.address[0]).show();
                                }
                                if (res.error.country) {
                                    $('#adminCountry-error').html(res.error.country[0]).show();
                                }
                            } else if (res?.message) {
                                toastr.error(res.message);
                            }
                        },
                        complete(){
                            $('#infoUpdate').attr('disabled', false);
                        }
                    });
                }
            });

            // Auto submit when image selected
            $('#profileImageInput').on('change', function () {
                $('#imageUploadForm').submit();
            });

            $('#imageUploadForm').validate({
                rules: {
                    image: { required: true },
                },
                submitHandler: function (form) {
                    let formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('admin-profile-image') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            const imageUrl = "{{ asset('upload') }}/" + res.data;

                            $('.profile-image')
                                .attr('src', imageUrl + '?t=' + new Date().getTime()); // cache busting

                            toastr.success(res.message);
                            $('#adminProfileImage-error').hide();
                        },

                        error: function (xhr) {
                            const res = xhr.responseJSON;
                            if (res?.error?.image) {
                                $('#adminProfileImage-error').html(res.error.image[0]).show();
                            } else {
                                toastr.error('Image upload failed');
                            }
                        }
                    });
                }
            });

            $('#changePasswordForm').validate({
                rules:{
                    currentPassword:{ required:true },
                    newPassword:{ required:true },
                    confirmPassword:{ required:true }
                },
                messages:{
                    currentPassword:{
                        required:"please enter currentPassword",
                    },
                    newPassword:{
                        required:"please enter newPassword",
                    },
                    confirmPassword:{
                        required:"please enter confirmPassword"
                    }
                },
                errorPlacement: function (error, element) {
                    let name = element.attr("name");
                    if (name === "currentPassword") {
                        $('#adminCurrentPassword-error').html(error.text()).show();
                    }
                    if (name === "newPassword") {
                        $('#adminNewPassword-error').html(error.text()).show();
                    }
                    if (name === "confirmPassword") {
                        $('#adminConfirmPassword-error').html(error.text()).show();
                    }
                },
                submitHandler:function (form, e) {
                    e.preventDefault();
                    var formData = new FormData(form);
                    $.ajax({
                        url:"{{route('admin-change-password')}}",
                        method:"POST",
                        dataType:"JSON",
                        data: formData,
                        processData:false,
                        contentType:false,
                        beforeSend:function (){
                            $('#changePasswordBtn').attr('disabled', true);
                        },
                        success:function (response){
                            toastr.success(response.message);
                            $('#changePasswordForm').reset();
                        },
                        error: function (xhr) {
                            let res = xhr.responseJSON;
                            console.log(res);
                            if (res?.error) {
                                if (res.error.currentPassword) {
                                    $('#adminCurrentPassword-error').html(res.error.currentPassword[0]).show();
                                }
                                if (res.error.newPassword) {
                                    $('#adminNewPassword-error').html(res.error.newPassword[0]).show();
                                }
                            } else if (res?.message) {
                                toastr.error(res.message);
                            }
                        },
                        complete:function (){
                            $('#changePasswordBtn').attr('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
@endsection
