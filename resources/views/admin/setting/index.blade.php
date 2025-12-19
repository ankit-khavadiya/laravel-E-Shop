@extends('admin.master')
@section('title','Settings')
@section('page-content')
    <!-- Settings Page -->
    <section id="settings" class="page">
        <div class="page-header">
            <h2>Settings</h2>
            <p class="text-muted">Configure your store settings and preferences.</p>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="profileSettingsForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" value="Admin" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" value="User" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="admin@eshop.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" value="+1 (555) 123-4567">
                            </div>
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="avatar" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Store Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="storeSettingsForm">
                            <div class="mb-3">
                                <label for="storeName" class="form-label">Store Name</label>
                                <input type="text" class="form-control" id="storeName" value="E-Shop" required>
                            </div>
                            <div class="mb-3">
                                <label for="storeEmail" class="form-label">Store Email</label>
                                <input type="email" class="form-control" id="storeEmail" value="support@eshop.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="storePhone" class="form-label">Store Phone</label>
                                <input type="tel" class="form-control" id="storePhone" value="+1 (555) 987-6543">
                            </div>
                            <div class="mb-3">
                                <label for="storeAddress" class="form-label">Store Address</label>
                                <textarea class="form-control" id="storeAddress" rows="3">123 Commerce St, Business City, BC 12345</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <select class="form-select" id="currency">
                                    <option value="USD" selected>US Dollar ($)</option>
                                    <option value="EUR">Euro (€)</option>
                                    <option value="GBP">British Pound (£)</option>
                                    <option value="JPY">Japanese Yen (¥)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@session('js')

@endsession
