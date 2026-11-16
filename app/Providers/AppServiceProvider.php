<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register custom phpmail transport (uses PHP native mail() - 100% proc_open safe)
        try {
            \Illuminate\Support\Facades\Mail::extend('phpmail', function (array $config = []) {
                return new \App\Mail\Transport\PhpMailTransport();
            });
        } catch (\Throwable $e) {}

        try {
            $mailer = env('MAIL_MAILER', 'phpmail');
            if (Schema::hasTable('site_settings')) {
                $mailer = SiteSetting::get('mail_mailer', $mailer);
                $fromAddress = SiteSetting::get('mail_from_address', env('MAIL_FROM_ADDRESS', 'noreply@muktadarboighor.com'));
                $fromName = SiteSetting::get('mail_from_name', env('MAIL_FROM_NAME', 'মুক্তাদার বইঘর'));

                // If sendmail is selected but proc_open is disabled on shared hosting, safely fallback to phpmail
                if ($mailer === 'sendmail' && !function_exists('proc_open')) {
                    $mailer = 'phpmail';
                }

                config([
                    'mail.default' => $mailer,
                    'mail.from.address' => $fromAddress,
                    'mail.from.name' => $fromName,
                ]);

                if ($mailer === 'smtp') {
                    $host = SiteSetting::get('mail_host', env('MAIL_HOST', 'mail.muktadarboighor.com'));
                    $port = SiteSetting::get('mail_port', env('MAIL_PORT', '465'));
                    $username = SiteSetting::get('mail_username', env('MAIL_USERNAME', 'info@muktadarboighor.com'));
                    $password = SiteSetting::get('mail_password', env('MAIL_PASSWORD', 'x-Qc-CJ1D5Xxgt0G'));
                    $encryption = SiteSetting::get('mail_encryption', env('MAIL_ENCRYPTION', 'ssl'));

                    $scheme = null;
                    if ($encryption === 'ssl' || (int) $port === 465) {
                        $scheme = 'smtps';
                    } elseif ($encryption === 'tls' || (int) $port === 587) {
                        $scheme = 'smtp';
                    }

                    if (!empty($host)) {
                        config([
                            'mail.mailers.smtp.host' => $host,
                            'mail.mailers.smtp.port' => (int) $port,
                            'mail.mailers.smtp.username' => $username,
                            'mail.mailers.smtp.password' => $password,
                            'mail.mailers.smtp.scheme' => $scheme,
                        ]);
                    }
                }
            } else {
                if ($mailer === 'sendmail' && !function_exists('proc_open')) {
                    config(['mail.default' => 'phpmail']);
                }
            }
        } catch (\Throwable $e) {
            // Safe fallback during early boot
        }
    }
}
