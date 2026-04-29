<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        // Get or create settings record
        $settings = Setting::first();

        // Pass data to view with separate variables as your form expects
        $store = $settings;
        $currency = $settings;
        $shipping = $settings;
        $payment = $settings;
        $order = $settings;
        $email = $settings;
        $security = $settings;
        $seo = $settings;
        $social = $settings;

        return view('admin.setting.index', compact(
            'store', 'currency', 'shipping', 'payment', 'order',
            'email', 'security', 'seo', 'social', 'settings'
        ));
    }

    public function update(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(),[
                // General Settings
                'store_name' => 'required|string|max:255',
                'store_email' => 'required|email|max:255',
                'store_phone' => 'nullable|string|max:20',
                'store_address' => 'nullable|string',
                'store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'store_favicon' => 'nullable|image|mimes:ico,png,jpg|max:1024',
                'store_banner' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
                'timezone' => 'nullable|string',
                'date_format' => 'nullable|string',
                'time_format' => 'nullable|string',
                'maintenance_mode' => 'nullable|boolean',
                'maintenance_message' => 'nullable|string',

                // Currency & Tax Settings
                'currency_code' => 'required|string|size:3',
                'currency_symbol' => 'required|string|max:10',
                'currency_position' => 'required|in:left,right,left_space,right_space',
                'decimal_places' => 'required|integer|min:0|max:4',
                'decimal_separator' => 'required|string|max:1',
                'thousand_separator' => 'required|string|max:1',
                'tax_rate' => 'required|numeric|min:0|max:100',
                'enable_tax' => 'nullable|boolean',
                'tax_calculation_method' => 'required|in:exclusive,inclusive',

                // Shipping Settings
                'enable_shipping' => 'nullable|boolean',
                'shipping_method' => 'required|in:flat_rate,free_shipping,weight_based,price_based',
                'flat_rate_cost' => 'nullable|numeric|min:0',
                'free_shipping_threshold' => 'nullable|numeric|min:0',
                'weight_rate' => 'nullable|numeric|min:0',
                'enable_local_pickup' => 'nullable|boolean',
                'pickup_address' => 'nullable|string',

                // Payment Settings
                'enable_cod' => 'nullable|boolean',
                'cod_instructions' => 'nullable|string',
                'enable_stripe' => 'nullable|boolean',
                'stripe_key' => 'nullable|string',
                'stripe_secret' => 'nullable|string',
                'enable_paypal' => 'nullable|boolean',
                'paypal_client_id' => 'nullable|string',
                'paypal_secret' => 'nullable|string',
                'paypal_mode' => 'nullable|in:sandbox,live',
                'enable_bank_transfer' => 'nullable|boolean',
                'bank_details' => 'nullable|string',

                // Order Settings
                'default_order_status' => 'required|in:pending,processing,confirmed,completed',
                'order_prefix' => 'required|string|max:20',
                'order_start_number' => 'required|integer|min:1000',
                'auto_invoice_generate' => 'nullable|boolean',
                'invoice_prefix' => 'required|string|max:20',
                'enable_order_note' => 'nullable|boolean',
                'enable_return_request' => 'nullable|boolean',
                'return_days_limit' => 'required|integer|min:1|max:365',

                // Email Settings
                'mail_driver' => 'required|string|max:50',
                'mail_host' => 'required|string|max:255',
                'mail_port' => 'required|integer|min:1|max:65535',
                'mail_username' => 'nullable|string',
                'mail_password' => 'nullable|string',
                'mail_encryption' => 'required|string|max:10',
                'mail_from_address' => 'nullable|email',
                'mail_from_name' => 'nullable|string|max:255',
                'enable_email_notification' => 'nullable|boolean',

                // Security Settings
                'enable_registration' => 'nullable|boolean',
                'email_verification' => 'nullable|boolean',
                'enable_2fa_admin' => 'nullable|boolean',
                'enable_captcha' => 'nullable|boolean',
                'captcha_site_key' => 'nullable|string',
                'captcha_secret_key' => 'nullable|string',
                'max_login_attempts' => 'required|integer|min:1|max:10',
                'lockout_time' => 'required|integer|min:1|max:60',
                'session_timeout' => 'nullable|boolean',
                'session_timeout_minutes' => 'required|integer|min:5|max:120',
                'force_ssl' => 'nullable|boolean',

                // SEO Settings
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string',
                'google_analytics_id' => 'nullable|string',
                'facebook_pixel_id' => 'nullable|string',
                'google_verification' => 'nullable|string',
                'header_scripts' => 'nullable|string',
                'footer_scripts' => 'nullable|string',

                // Social Settings
                'facebook_url' => 'nullable|url',
                'twitter_url' => 'nullable|url',
                'instagram_url' => 'nullable|url',
                'youtube_url' => 'nullable|url',
                'linkedin_url' => 'nullable|url',
                'pinterest_url' => 'nullable|url',
                'show_social_icons' => 'nullable|boolean',
            ]);

            if($validator->fails()){
                return $this->sendValidationError($validator->errors());
            }

            // Get all request data
            $validated = $request->except('_token');

            $settingsImage = Setting::select('store_logo','store_favicon','store_banner')->first();

            // Handle Logo Upload
            if ($request->hasFile('store_logo')) {
                if ($settingsImage->store_logo) {
                    $oldPath = public_path('upload/logo/' . $settingsImage->store_logo);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $logo = $request->file('store_logo');
                $logoName = fileName($logo->getClientOriginalExtension());
                $logo->move(public_path('upload/logo'), $logoName);
                $validated['store_logo'] = $logoName;
            }

            // Handle Favicon Upload
            if ($request->hasFile('store_favicon')) {
                if ($settingsImage->store_favicon) {
                    $oldPath = public_path($settingsImage->store_favicon);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $favicon = $request->file('store_favicon');
                $faviconName =  'favicon.' . $favicon->getClientOriginalExtension();
                $favicon->move(public_path(), $faviconName);
                $validated['store_favicon'] = $faviconName;
            }

            // Handle Banner Upload
            if ($request->hasFile('store_banner')) {
                if ($settingsImage->store_banner) {
                    $oldPath = public_path('upload/banner/'.$settingsImage->store_banner);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $banner = $request->file('store_banner');
                $bannerName = fileName($banner->getClientOriginalExtension());
                $banner->move(public_path('upload/banner'), $bannerName);
                $validated['store_banner'] = $bannerName;
            }

            // Handle Checkbox Fields (if checkbox is not present in request, it means it was unchecked)
            $checkboxFields = [
                'maintenance_mode', 'enable_tax', 'enable_shipping', 'enable_local_pickup',
                'enable_cod', 'enable_stripe', 'enable_paypal', 'enable_bank_transfer',
                'auto_invoice_generate', 'enable_order_note', 'enable_return_request',
                'enable_email_notification', 'enable_registration', 'email_verification',
                'enable_2fa_admin', 'enable_captcha', 'session_timeout', 'force_ssl',
                'show_social_icons'
            ];

            foreach ($checkboxFields as $checkbox) {
                $validated[$checkbox] = $request->has($checkbox) ? true : false;
            }

            Setting::updateOrCreate(
                ['id' => 1],   // always update single row
                $validated
            );

            return $this->sendSuccess('Setting updated successfully.');

        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }
}
