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
                    $host = SiteSetting::get('mail_host');
                    $port = SiteSetting::get('mail_port', '465');
                    $username = SiteSetting::get('mail_username');
                    $password = SiteSetting::get('mail_password');
                    $encryption = SiteSetting::get('mail_encryption', 'ssl');

                    if (!empty($host)) {
                        config([
                            'mail.mailers.smtp.host' => $host,
                            'mail.mailers.smtp.port' => (int) $port,
                            'mail.mailers.smtp.username' => $username,
                            'mail.mailers.smtp.password' => $password,
                            'mail.mailers.smtp.scheme' => ($encryption === 'ssl' || $encryption === 'tls') ? $encryption : null,
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
