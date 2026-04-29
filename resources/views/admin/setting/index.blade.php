@extends('admin.master')
@section('title', 'Settings')
@section('page-content')

    <style>

    </style>

    <div class="container-fluid px-4">
        <div class="page-header mb-4">
            <h2>Settings</h2>
            <p class="text-muted">Configure your store settings and preferences.</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card settings-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i> Store Configuration</h5>
                    </div>

                    <div class="card-body">
                        <!-- Tabs Navigation - Responsive -->
                        <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general">
                                    <i class="fas fa-store me-2"></i> General
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#currency">
                                    <i class="fas fa-dollar-sign me-2"></i> Currency & Tax
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping">
                                    <i class="fas fa-truck me-2"></i> Shipping
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#payment">
                                    <i class="fas fa-credit-card me-2"></i> Payment
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#order">
                                    <i class="fas fa-shopping-cart me-2"></i> Order
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#email">
                                    <i class="fas fa-envelope me-2"></i> Email
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#security">
                                    <i class="fas fa-shield-alt me-2"></i> Security
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#seo">
                                    <i class="fas fa-search me-2"></i> SEO
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#social">
                                    <i class="fas fa-share-alt me-2"></i> Social
                                </button>
                            </li>
                        </ul>
{{--@dd($store)--}}
                        <form id="settingsForm" enctype="multipart/form-data">
                            @csrf
                            <div class="tab-content">

                                <!-- GENERAL SETTINGS TAB -->
                                <div class="tab-pane fade show active" id="general">
                                    <div class="settings-group">
                                        <h6><i class="fas fa-info-circle me-2"></i> Basic Information</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Store Name *</label>
                                                <input type="text" name="store_name" class="form-control" value="{{ $store->store_name ?? 'E-Shop' }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Store Email *</label>
                                                <input type="email" name="store_email" class="form-control" value="{{ $store->store_email ?? 'support@eshop.com' }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Store Phone</label>
                                                <input type="text" name="store_phone" class="form-control" value="{{ $store->store_phone ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Timezone</label>
                                                <select name="timezone" class="form-select">
                                                    <option value="UTC" {{ ($store->timezone ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                    <option value="Asia/Kolkata" {{ ($store->timezone ?? '') == 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata</option>
                                                    <option value="America/New_York" {{ ($store->timezone ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New York</option>
                                                    <option value="Europe/London" {{ ($store->timezone ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                                    <option value="Europe/Oslo" {{ ($store->timezone ?? '') == 'Europe/Oslo' ? 'selected' : '' }}>Europe/Oslo</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Store Address</label>
                                                <textarea name="store_address" class="form-control" rows="2">{{ $store->store_address ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-images me-2"></i> Store Branding</h6>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Store Logo</label>
                                                <input type="file" name="store_logo" class="form-control" accept="image/*">
                                                @if(isset($store->store_logo))
                                                    <img src="{{ asset('upload/logo/'.$store->store_logo) }}" class="image-preview mt-2" alt="Logo Preview" id="logoPreview">
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Favicon</label>
                                                <input type="file" name="store_favicon" class="form-control" accept="image/*">
                                                @if(isset($store->store_favicon))
                                                    <img src="{{ asset($store->store_favicon) }}" class="image-preview mt-2" alt="Favicon Preview" id="faviconPreview">
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Store Banner</label>
                                                <input type="file" name="store_banner" class="form-control" accept="image/*">
                                                @if(isset($store->store_banner))
                                                    <img src="{{ asset('upload/banner/'.$store->store_banner) }}" class="image-preview mt-2" alt="Banner Preview" id="bannerPreview">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-calendar-alt me-2"></i> Date & Time Format</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Date Format</label>
                                                <select name="date_format" class="form-select">
                                                    <option value="Y-m-d" {{ ($store->date_format ?? '') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                                    <option value="d-m-Y" {{ ($store->date_format ?? '') == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                                                    <option value="m/d/Y" {{ ($store->date_format ?? '') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Time Format</label>
                                                <select name="time_format" class="form-select">
                                                    <option value="H:i:s" {{ ($store->time_format ?? '') == 'H:i:s' ? 'selected' : '' }}>24 Hour</option>
                                                    <option value="h:i:s A" {{ ($store->time_format ?? '') == 'h:i:s A' ? 'selected' : '' }}>12 Hour</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-tools me-2"></i> Maintenance Mode</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" id="maintenanceMode" {{ ($store->maintenance_mode ?? '0') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="maintenanceMode">Enable Maintenance Mode</label>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Maintenance Message</label>
                                                <textarea name="maintenance_message" class="form-control" rows="2">{{ $store->maintenance_message ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- CURRENCY & TAX TAB -->
                                <div class="tab-pane fade" id="currency">
                                    <div class="settings-group">
                                        <h6><i class="fas fa-money-bill-wave me-2"></i> Currency Settings</h6>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Currency Code</label>
                                                <select name="currency_code" class="form-select">
                                                    <option value="USD" {{ ($currency->currency_code ?? '') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                                    <option value="EUR" {{ ($currency->currency_code ?? '') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                                    <option value="GBP" {{ ($currency->currency_code ?? '') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                                    <option value="INR" {{ ($currency->currency_code ?? '') == 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                                                    <option value="NOK" {{ ($currency->currency_code ?? '') == 'NOK' ? 'selected' : '' }}>NOK - Norwegian Krone</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Currency Symbol</label>
                                                <input type="text" name="currency_symbol" class="form-control" value="{{ $currency->currency_symbol ?? '$' }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Currency Position</label>
                                                <select name="currency_position" class="form-select">
                                                    <option value="left" {{ ($currency->currency_position ?? '') == 'left' ? 'selected' : '' }}>$100 (Left)</option>
                                                    <option value="right" {{ ($currency->currency_position ?? '') == 'right' ? 'selected' : '' }}>100$ (Right)</option>
                                                    <option value="left_space" {{ ($currency->currency_position ?? '') == 'left_space' ? 'selected' : '' }}>$ 100 (Left with space)</option>
                                                    <option value="right_space" {{ ($currency->currency_position ?? '') == 'right_space' ? 'selected' : '' }}>100 $ (Right with space)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Decimal Places</label>
                                                <input type="number" name="decimal_places" class="form-control" value="{{ $currency->decimal_places ?? 2 }}" min="0" max="4">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Decimal Separator</label>
                                                <input type="text" name="decimal_separator" class="form-control" value="{{ $currency->decimal_separator ?? '.' }}" maxlength="1">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Thousand Separator</label>
                                                <input type="text" name="thousand_separator" class="form-control" value="{{ $currency->thousand_separator ?? ',' }}" maxlength="1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-percent me-2"></i> Tax Settings</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_tax" value="1" id="enableTax" {{ ($currency->enable_tax ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableTax">Enable Tax</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tax Rate (%)</label>
                                                <input type="number" name="tax_rate" class="form-control" value="{{ $currency->tax_rate ?? 0 }}" step="0.01" min="0" max="100">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Tax Calculation Method</label>
                                                <select name="tax_calculation_method" class="form-select">
                                                    <option value="exclusive" {{ ($currency->tax_calculation_method ?? '') == 'exclusive' ? 'selected' : '' }}>Exclusive (Tax added to price)</option>
                                                    <option value="inclusive" {{ ($currency->tax_calculation_method ?? '') == 'inclusive' ? 'selected' : '' }}>Inclusive (Tax included in price)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SHIPPING SETTINGS TAB -->
                                <div class="tab-pane fade" id="shipping">
                                    <div class="settings-group">
                                        <h6><i class="fas fa-truck-moving me-2"></i> Shipping Configuration</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_shipping" value="1" id="enableShipping" {{ ($shipping->enable_shipping ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableShipping">Enable Shipping</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Shipping Method</label>
                                                <select name="shipping_method" class="form-select">
                                                    <option value="flat_rate" {{ ($shipping->shipping_method ?? '') == 'flat_rate' ? 'selected' : '' }}>Flat Rate</option>
                                                    <option value="free_shipping" {{ ($shipping->shipping_method ?? '') == 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                                                    <option value="weight_based" {{ ($shipping->shipping_method ?? '') == 'weight_based' ? 'selected' : '' }}>Weight Based</option>
                                                    <option value="price_based" {{ ($shipping->shipping_method ?? '') == 'price_based' ? 'selected' : '' }}>Price Based</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Flat Rate Cost ($)</label>
                                                <input type="number" name="flat_rate_cost" class="form-control" value="{{ $shipping->flat_rate_cost ?? 5.00 }}" step="0.01">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Free Shipping Threshold ($)</label>
                                                <input type="number" name="free_shipping_threshold" class="form-control" value="{{ $shipping->free_shipping_threshold ?? 50.00 }}" step="0.01">
                                                <small class="text-muted">Free shipping applies when order amount reaches this value</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Weight Rate ($/kg)</label>
                                                <input type="number" name="weight_rate" class="form-control" value="{{ $shipping->weight_rate ?? 2.00 }}" step="0.01">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_local_pickup" value="1" id="localPickup" {{ ($shipping->enable_local_pickup ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="localPickup">Enable Local Pickup</label>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Pickup Address</label>
                                                <textarea name="pickup_address" class="form-control" rows="2">{{ $shipping->pickup_address ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PAYMENT SETTINGS TAB -->
                                <div class="tab-pane fade" id="payment">
                                    <div class="settings-group">
                                        <h6><i class="fas fa-money-bill-alt me-2"></i> Payment Methods</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_cod" value="1" id="enableCOD" {{ ($payment->enable_cod ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableCOD">Cash on Delivery (COD)</label>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3" id="codInstructionsDiv">
                                                <label class="form-label">COD Instructions</label>
                                                <textarea name="cod_instructions" class="form-control" rows="2">{{ $payment->cod_instructions ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fab fa-stripe me-2"></i> Stripe Payment</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_stripe" value="1" id="enableStripe" {{ ($payment->enable_stripe ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableStripe">Enable Stripe</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Stripe Publishable Key</label>
                                                <input type="text" name="stripe_key" class="form-control" value="{{ $payment->stripe_key ?? '' }}">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Stripe Secret Key</label>
                                                <input type="password" name="stripe_secret" class="form-control" value="{{ $payment->stripe_secret ?? '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fab fa-paypal me-2"></i> PayPal Payment</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_paypal" value="1" id="enablePaypal" {{ ($payment->enable_paypal ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enablePaypal">Enable PayPal</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">PayPal Mode</label>
                                                <select name="paypal_mode" class="form-select">
                                                    <option value="sandbox" {{ ($payment->paypal_mode ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox (Testing)</option>
                                                    <option value="live" {{ ($payment->paypal_mode ?? '') == 'live' ? 'selected' : '' }}>Live (Production)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">PayPal Client ID</label>
                                                <input type="text" name="paypal_client_id" class="form-control" value="{{ $payment->paypal_client_id ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">PayPal Secret</label>
                                                <input type="password" name="paypal_secret" class="form-control" value="{{ $payment->paypal_secret ?? '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-university me-2"></i> Bank Transfer</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_bank_transfer" value="1" id="enableBankTransfer" {{ ($payment->enable_bank_transfer ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableBankTransfer">Enable Bank Transfer</label>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Bank Account Details</label>
                                                <textarea name="bank_details" class="form-control" rows="3">{{ $payment->bank_details ?? '' }}</textarea>
                                                <small class="text-muted">Enter bank name, account number, IFSC code, etc.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ORDER SETTINGS TAB -->
                                <div class="tab-pane fade" id="order">
                                    <div class="settings-group">
                                        <h6><i class="fas fa-shopping-cart me-2"></i> Order Configuration</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Default Order Status</label>
                                                <select name="default_order_status" class="form-select">
                                                    <option value="pending" {{ ($order->default_order_status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ ($order->default_order_status ?? '') == 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="confirmed" {{ ($order->default_order_status ?? '') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Order Prefix</label>
                                                <input type="text" name="order_prefix" class="form-control" value="{{ $order->order_prefix ?? 'ORD-' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Order Starting Number</label>
                                                <input type="number" name="order_start_number" class="form-control" value="{{ $order->order_start_number ?? 1000 }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="auto_invoice_generate" value="1" id="autoInvoice" {{ ($order->auto_invoice_generate ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="autoInvoice">Auto Generate Invoice</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Invoice Prefix</label>
                                                <input type="text" name="invoice_prefix" class="form-control" value="{{ $order->invoice_prefix ?? 'INV-' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-exchange-alt me-2"></i> Return Policy</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_return_request" value="1" id="enableReturn" {{ ($order->enable_return_request ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableReturn">Enable Return Request</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Return Days Limit</label>
                                                <input type="number" name="return_days_limit" class="form-control" value="{{ $order->return_days_limit ?? 30 }}">
                                                <small class="text-muted">Days after delivery customer can request return</small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_order_note" value="1" id="enableOrderNote" {{ ($order->enable_order_note ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableOrderNote">Allow Order Notes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- EMAIL SETTINGS TAB -->
                                <div class="tab-pane fade" id="email">
                                    <div class="settings-group">
                                        <h6><i class="fas fa-envelope me-2"></i> SMTP Configuration</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Mail Driver</label>
                                                <select name="mail_driver" class="form-select">
                                                    <option value="smtp" {{ ($email->mail_driver ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                                    <option value="sendmail" {{ ($email->mail_driver ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                                    <option value="mailgun" {{ ($email->mail_driver ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SMTP Host</label>
                                                <input type="text" name="mail_host" class="form-control" value="{{ $email->mail_host ?? 'smtp.mailtrap.io' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SMTP Port</label>
                                                <input type="number" name="mail_port" class="form-control" value="{{ $email->mail_port ?? 2525 }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Encryption</label>
                                                <select name="mail_encryption" class="form-select">
                                                    <option value="tls" {{ ($email->mail_encryption ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                                    <option value="ssl" {{ ($email->mail_encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SMTP Username</label>
                                                <input type="text" name="mail_username" class="form-control" value="{{ $email->mail_username ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SMTP Password</label>
                                                <input type="password" name="mail_password" class="form-control" value="{{ $email->mail_password ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">From Email</label>
                                                <input type="email" name="mail_from_address" class="form-control" value="{{ $email->mail_from_address ?? '' }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">From Name</label>
                                                <input type="text" name="mail_from_name" class="form-control" value="{{ $email->mail_from_name ?? '' }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-bell me-2"></i> Email Notifications</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_email_notification" value="1" id="enableEmailNotification" {{ ($email->enable_email_notification ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableEmailNotification">Enable Email Notifications</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SECURITY SETTINGS TAB -->
                                <div class="tab-pane fade" id="security">
                                    <div class="settings-group">
                                        <h6><i class="fas fa-user-lock me-2"></i> User Security</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_registration" value="1" id="enableRegistration" {{ ($security->enable_registration ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableRegistration">Allow New Registration</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="email_verification" value="1" id="emailVerification" {{ ($security->email_verification ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="emailVerification">Require Email Verification</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_2fa_admin" value="1" id="enable2FA" {{ ($security->enable_2fa_admin ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enable2FA">Enable 2FA for Admin</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="session_timeout" value="1" id="sessionTimeout" {{ ($security->session_timeout ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sessionTimeout">Auto Session Timeout</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Session Timeout (minutes)</label>
                                                <input type="number" name="session_timeout_minutes" class="form-control" value="{{ $security->session_timeout_minutes ?? 30 }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-shield-alt me-2"></i> Login Protection</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Max Login Attempts</label>
                                                <input type="number" name="max_login_attempts" class="form-control" value="{{ $security->max_login_attempts ?? 5 }}" min="1" max="10">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Lockout Time (minutes)</label>
                                                <input type="number" name="lockout_time" class="form-control" value="{{ $security->lockout_time ?? 15 }}" min="1" max="60">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="force_ssl" value="1" id="forceSSL" {{ ($security->force_ssl ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="forceSSL">Force HTTPS/SSL</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-robot me-2"></i> reCAPTCHA Settings</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="enable_captcha" value="1" id="enableCaptcha" {{ ($security->enable_captcha ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="enableCaptcha">Enable reCAPTCHA</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">reCAPTCHA Site Key</label>
                                                <input type="text" name="captcha_site_key" class="form-control" value="{{ $security->captcha_site_key ?? '' }}">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">reCAPTCHA Secret Key</label>
                                                <input type="password" name="captcha_secret_key" class="form-control" value="{{ $security->captcha_secret_key ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO SETTINGS TAB -->
                                <div class="tab-pane fade" id="seo">
                                    <div class="settings-group">
                                        <h6><i class="fas fa-chart-line me-2"></i> Meta Tags</h6>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Default Meta Title</label>
                                                <input type="text" name="meta_title" class="form-control" value="{{ $seo->meta_title ?? '' }}">
                                                <small class="text-muted">Recommended length: 50-60 characters</small>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Default Meta Description</label>
                                                <textarea name="meta_description" class="form-control" rows="2">{{ $seo->meta_description ?? '' }}</textarea>
                                                <small class="text-muted">Recommended length: 150-160 characters</small>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Meta Keywords</label>
                                                <input type="text" name="meta_keywords" class="form-control" value="{{ $seo->meta_keywords ?? '' }}">
                                                <small class="text-muted">Separate keywords with commas</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fab fa-google me-2"></i> Analytics & Tracking</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Google Analytics ID</label>
                                                <input type="text" name="google_analytics_id" class="form-control" value="{{ $seo->google_analytics_id ?? '' }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Facebook Pixel ID</label>
                                                <input type="text" name="facebook_pixel_id" class="form-control" value="{{ $seo->facebook_pixel_id ?? '' }}">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Google Search Console Verification</label>
                                                <input type="text" name="google_verification" class="form-control" value="{{ $seo->google_verification ?? '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings-group">
                                        <h6><i class="fas fa-code me-2"></i> Custom Scripts</h6>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Header Scripts</label>
                                                <textarea name="header_scripts" class="form-control" rows="4" placeholder="Add custom CSS, JS, or meta tags that will be added to head section">{{ $seo->header_scripts ?? '' }}</textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Footer Scripts</label>
                                                <textarea name="footer_scripts" class="form-control" rows="4" placeholder="Add custom JavaScript that will be added before closing body tag">{{ $seo->footer_scripts ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SOCIAL SETTINGS TAB -->
                                <div class="tab-pane fade" id="social">
                                    <div class="settings-group">
                                        <h6><i class="fas fa-share-alt me-2"></i> Social Media Links</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="fab fa-facebook me-2"></i> Facebook</label>
                                                <input type="url" name="facebook_url" class="form-control" value="{{ $social->facebook_url ?? '' }}" placeholder="https://facebook.com/yourpage">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="fab fa-twitter me-2"></i> Twitter/X</label>
                                                <input type="url" name="twitter_url" class="form-control" value="{{ $social->twitter_url ?? '' }}" placeholder="https://twitter.com/yourhandle">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="fab fa-instagram me-2"></i> Instagram</label>
                                                <input type="url" name="instagram_url" class="form-control" value="{{ $social->instagram_url ?? '' }}" placeholder="https://instagram.com/yourprofile">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="fab fa-youtube me-2"></i> YouTube</label>
                                                <input type="url" name="youtube_url" class="form-control" value="{{ $social->youtube_url ?? '' }}" placeholder="https://youtube.com/@yourchannel">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="fab fa-linkedin me-2"></i> LinkedIn</label>
                                                <input type="url" name="linkedin_url" class="form-control" value="{{ $social->linkedin_url ?? '' }}" placeholder="https://linkedin.com/company/yourcompany">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label"><i class="fab fa-pinterest me-2"></i> Pinterest</label>
                                                <input type="url" name="pinterest_url" class="form-control" value="{{ $social->pinterest_url ?? '' }}" placeholder="https://pinterest.com/yourprofile">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="show_social_icons" value="1" id="showSocialIcons" {{ ($social->show_social_icons ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="showSocialIcons">Show Social Icons on Website</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Submit Button -->
                            <div class="mt-4 text-end">
                                <button type="submit" name="submit" class="btn btn-primary" id="saveSettingsBtn">
                                    <i class="fas fa-save me-2"></i> Save All Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastMessage" class="toast-message d-none">
        <div class="alert alert-success shadow-lg">
            <i class="fas fa-check-circle me-2"></i> Settings saved successfully!
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Image preview on file input change
            $('input[type="file"]').change(function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $(event.target).closest('.mb-3').find('.image-preview');
                        if (img.length) {
                            img.attr('src', e.target.result);
                        } else {
                            $(event.target).after(`<img src="${e.target.result}" class="image-preview mt-2" alt="Preview">`);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form submission
            $('#settingsForm').validate({
                errorClass: "error text-danger",
                submitHandler:function (form) {
                    let formData = new FormData(form);
                    const section = $('.tab-pane.active').attr('id');
                    formData.append('section', section);
                    const submitBtn = $('#saveSettingsBtn');
                    submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Saving...');
                    submitBtn.addClass('btn-loading');
                    $.ajax({
                        url: "{{ route('settings.update') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend:function (){
                            // $('.field-error,span').text('').hide();
                            // $('.error').removeClass('error text-danger');
                            // $('#saveProductBtn').attr('disabled', true);
                        },
                        success: function (response) {
                            toastr.success(response.message);
                        },
                        error: function (xhr) {
                            let res = xhr.responseJSON;
                            toastr.error(res.message);
                        },
                        complete: function () {
                            setTimeout(() => {
                                submitBtn.html('<i class="fas fa-save me-2"></i> Save All Settings');
                                submitBtn.removeClass('btn-loading');
                            }, 1000);
                        }
                    });
                }
            });

            // Conditional field visibility
            $('#enableCOD').change(function() {
                if ($(this).is(':checked')) {
                    $('#codInstructionsDiv').slideDown();
                } else {
                    $('#codInstructionsDiv').slideUp();
                }
            }).trigger('change');

            // Session timeout checkbox handling
            $('#sessionTimeout').change(function() {
                const timeoutField = $('input[name="session_timeout_minutes"]').closest('.col-md-6');
                if ($(this).is(':checked')) {
                    timeoutField.slideDown();
                } else {
                    timeoutField.slideUp();
                }
            }).trigger('change');
        });
    </script>
@endsection
