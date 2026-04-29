<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        // General Settings
        'store_name', 'store_email', 'store_phone', 'store_address',
        'store_logo', 'store_favicon', 'store_banner', 'timezone',
        'date_format', 'time_format', 'maintenance_mode', 'maintenance_message',

        // Currency & Tax Settings
        'currency_code', 'currency_symbol', 'currency_position', 'decimal_places',
        'decimal_separator', 'thousand_separator', 'tax_rate', 'enable_tax',
        'tax_calculation_method',

        // Shipping Settings
        'enable_shipping', 'shipping_method', 'flat_rate_cost', 'free_shipping_threshold',
        'weight_rate', 'enable_local_pickup', 'pickup_address',

        // Payment Settings
        'enable_cod', 'cod_instructions', 'enable_stripe', 'stripe_key',
        'stripe_secret', 'enable_paypal', 'paypal_client_id', 'paypal_secret',
        'paypal_mode', 'enable_bank_transfer', 'bank_details',

        // Order Settings
        'default_order_status', 'order_prefix', 'order_start_number',
        'auto_invoice_generate', 'invoice_prefix', 'enable_order_note',
        'enable_return_request', 'return_days_limit',

        // Email Settings
        'mail_driver', 'mail_host', 'mail_port', 'mail_username', 'mail_password',
        'mail_encryption', 'mail_from_address', 'mail_from_name', 'enable_email_notification',

        // Security Settings
        'enable_registration', 'email_verification', 'enable_2fa_admin',
        'enable_captcha', 'captcha_site_key', 'captcha_secret_key',
        'max_login_attempts', 'lockout_time', 'session_timeout',
        'session_timeout_minutes', 'force_ssl',

        // SEO Settings
        'meta_title', 'meta_description', 'meta_keywords', 'google_analytics_id',
        'facebook_pixel_id', 'google_verification', 'header_scripts', 'footer_scripts',

        // Social Settings
        'facebook_url', 'twitter_url', 'instagram_url', 'youtube_url',
        'linkedin_url', 'pinterest_url', 'show_social_icons'
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'enable_tax' => 'boolean',
        'enable_shipping' => 'boolean',
        'enable_local_pickup' => 'boolean',
        'enable_cod' => 'boolean',
        'enable_stripe' => 'boolean',
        'enable_paypal' => 'boolean',
        'enable_bank_transfer' => 'boolean',
        'auto_invoice_generate' => 'boolean',
        'enable_order_note' => 'boolean',
        'enable_return_request' => 'boolean',
        'enable_email_notification' => 'boolean',
        'enable_registration' => 'boolean',
        'email_verification' => 'boolean',
        'enable_2fa_admin' => 'boolean',
        'enable_captcha' => 'boolean',
        'session_timeout' => 'boolean',
        'force_ssl' => 'boolean',
        'show_social_icons' => 'boolean',
        'decimal_places' => 'integer',
        'max_login_attempts' => 'integer',
        'lockout_time' => 'integer',
        'session_timeout_minutes' => 'integer',
        'return_days_limit' => 'integer',
        'order_start_number' => 'integer',
        'mail_port' => 'integer',
        'tax_rate' => 'decimal:2',
        'flat_rate_cost' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'weight_rate' => 'decimal:2',
    ];

//    // Helper method to get single setting value
//    public static function get($key, $default = null)
//    {
//        $settings = self::first();
//        return $settings ? $settings->$key : $default;
//    }
//
//    // Helper method to update single setting
//    public static function set($key, $value)
//    {
//        $settings = self::first();
//        if (!$settings) {
//            $settings = new self();
//        }
//        $settings->$key = $value;
//        $settings->save();
//        return $settings;
//    }
}
