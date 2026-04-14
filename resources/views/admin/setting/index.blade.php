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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Store Settings</h5>
                    </div>

                    <div class="card-body">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-3" id="settingsTabs" role="tablist">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general">General</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#currency">Currency & Tax</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping">Shipping</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#payment">Payment</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#order">Order</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#email">Email</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#security">Security</button></li>
                        </ul>

                        <form id="storeSettingsForm" enctype="multipart/form-data">
                            @csrf

                            <div class="tab-content">

                                <!-- GENERAL -->
                                <div class="tab-pane fade show active" id="general">
                                    <div class="mb-3">
                                        <label class="form-label">Store Name</label>
                                        <input type="text" name="store_name" class="form-control" value="E-Shop">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Store Email</label>
                                        <input type="email" name="store_email" class="form-control" value="support@eshop.com">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Store Phone</label>
                                        <input type="text" name="store_phone" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Store Address</label>
                                        <textarea name="store_address" class="form-control"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Store Logo</label>
                                        <input type="file" name="store_logo" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Timezone</label>
                                        <select name="timezone" class="form-select">
                                            <option value="UTC">UTC</option>
                                            <option value="Asia/Kolkata">Asia/Kolkata</option>
                                            <option value="Europe/Oslo">Europe/Oslo</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- CURRENCY -->
                                <div class="tab-pane fade" id="currency">
                                    <div class="mb-3">
                                        <label class="form-label">Currency</label>
                                        <select name="currency" class="form-select">
                                            <option value="USD">$ USD</option>
                                            <option value="EUR">€ EUR</option>
                                            <option value="GBP">£ GBP</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Currency Position</label>
                                        <select name="currency_position" class="form-select">
                                            <option value="left">$100</option>
                                            <option value="right">100$</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tax (%)</label>
                                        <input type="number" name="tax" class="form-control" value="10">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Enable Tax</label>
                                        <select name="enable_tax" class="form-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- SHIPPING -->
                                <div class="tab-pane fade" id="shipping">
                                    <div class="mb-3">
                                        <label class="form-label">Shipping Charge</label>
                                        <input type="number" name="shipping_charge" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Free Shipping Above</label>
                                        <input type="number" name="free_shipping" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Enable Shipping</label>
                                        <select name="enable_shipping" class="form-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- PAYMENT -->
                                <div class="tab-pane fade" id="payment">
                                    <div class="mb-3">
                                        <label class="form-label">Enable COD</label>
                                        <select name="cod" class="form-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Stripe Key</label>
                                        <input type="text" name="stripe_key" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Stripe Secret</label>
                                        <input type="text" name="stripe_secret" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">PayPal Email</label>
                                        <input type="email" name="paypal_email" class="form-control">
                                    </div>
                                </div>

                                <!-- ORDER -->
                                <div class="tab-pane fade" id="order">
                                    <div class="mb-3">
                                        <label class="form-label">Default Order Status</label>
                                        <select name="order_status" class="form-select">
                                            <option value="pending">Pending</option>
                                            <option value="processing">Processing</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Invoice Prefix</label>
                                        <input type="text" name="invoice_prefix" class="form-control" value="INV-">
                                    </div>
                                </div>

                                <!-- EMAIL -->
                                <div class="tab-pane fade" id="email">
                                    <div class="mb-3">
                                        <label class="form-label">SMTP Host</label>
                                        <input type="text" name="smtp_host" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">SMTP Port</label>
                                        <input type="number" name="smtp_port" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">SMTP Email</label>
                                        <input type="email" name="smtp_email" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">SMTP Password</label>
                                        <input type="password" name="smtp_password" class="form-control">
                                    </div>
                                </div>

                                <!-- SECURITY -->
                                <div class="tab-pane fade" id="security">
                                    <div class="mb-3">
                                        <label class="form-label">Enable Registration</label>
                                        <select name="registration" class="form-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email Verification</label>
                                        <select name="email_verification" class="form-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <!-- Submit -->
                            <div class="mt-4">
                                <button type="submit" name="submit" class="btn btn-primary">Save All Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@session('js')

@endsession
