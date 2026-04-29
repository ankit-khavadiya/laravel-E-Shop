<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // General Settings
            $table->string('store_name')->default('E-Shop');
            $table->string('store_email')->default('admin@eshop.com');
            $table->string('store_phone')->nullable();
            $table->text('store_address')->nullable();
            $table->string('store_logo')->nullable();
            $table->string('store_favicon')->nullable();
            $table->string('store_banner')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('date_format')->default('Y-m-d');
            $table->string('time_format')->default('H:i:s');
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();

            // Currency & Tax Settings
            $table->string('currency_code', 3)->default('USD');
            $table->string('currency_symbol', 10)->default('$');
            $table->enum('currency_position', ['left', 'right', 'left_space', 'right_space'])->default('left');
            $table->integer('decimal_places')->default(2);
            $table->string('decimal_separator')->default('.');
            $table->string('thousand_separator')->default(',');
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->boolean('enable_tax')->default(true);
            $table->enum('tax_calculation_method', ['exclusive', 'inclusive'])->default('exclusive');

            // Shipping Settings
            $table->boolean('enable_shipping')->default(true);
            $table->enum('shipping_method', ['flat_rate', 'free_shipping', 'weight_based', 'price_based'])->default('flat_rate');
            $table->decimal('flat_rate_cost', 10, 2)->default(5.00);
            $table->decimal('free_shipping_threshold', 10, 2)->default(50.00);
            $table->decimal('weight_rate', 10, 2)->nullable();
            $table->boolean('enable_local_pickup')->default(false);
            $table->text('pickup_address')->nullable();

            // Payment Settings
            $table->boolean('enable_cod')->default(true);
            $table->text('cod_instructions')->nullable();
            $table->boolean('enable_stripe')->default(false);
            $table->string('stripe_key')->nullable();
            $table->string('stripe_secret')->nullable();
            $table->boolean('enable_paypal')->default(false);
            $table->string('paypal_client_id')->nullable();
            $table->string('paypal_secret')->nullable();
            $table->enum('paypal_mode', ['sandbox', 'live'])->default('sandbox');
            $table->boolean('enable_bank_transfer')->default(false);
            $table->text('bank_details')->nullable();

            // Order Settings
            $table->enum('default_order_status', ['pending', 'processing', 'confirmed', 'completed'])->default('pending');
            $table->string('order_prefix', 20)->default('ORD-');
            $table->integer('order_start_number')->default(1000);
            $table->boolean('auto_invoice_generate')->default(true);
            $table->string('invoice_prefix', 20)->default('INV-');
            $table->boolean('enable_order_note')->default(true);
            $table->boolean('enable_return_request')->default(true);
            $table->integer('return_days_limit')->default(30);

            // Email Settings
            $table->string('mail_driver')->default('smtp');
            $table->string('mail_host')->default('smtp.mailtrap.io');
            $table->integer('mail_port')->default(2525);
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_encryption')->default('tls');
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();
            $table->boolean('enable_email_notification')->default(true);

            // Security Settings
            $table->boolean('enable_registration')->default(true);
            $table->boolean('email_verification')->default(false);
            $table->boolean('enable_2fa_admin')->default(false);
            $table->boolean('enable_captcha')->default(false);
            $table->string('captcha_site_key')->nullable();
            $table->string('captcha_secret_key')->nullable();
            $table->integer('max_login_attempts')->default(5);
            $table->integer('lockout_time')->default(15);
            $table->boolean('session_timeout')->default(true);
            $table->integer('session_timeout_minutes')->default(30);
            $table->boolean('force_ssl')->default(false);

            // SEO Settings
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->string('facebook_pixel_id')->nullable();
            $table->string('google_verification')->nullable();
            $table->text('header_scripts')->nullable();
            $table->text('footer_scripts')->nullable();

            // Social Settings
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('pinterest_url')->nullable();
            $table->boolean('show_social_icons')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
