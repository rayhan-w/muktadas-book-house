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
        try {
            if (Schema::hasTable('site_settings')) {
                $mailer = SiteSetting::get('mail_mailer', env('MAIL_MAILER', 'sendmail'));
                $fromAddress = SiteSetting::get('mail_from_address', env('MAIL_FROM_ADDRESS', 'noreply@muktadarboighor.com'));
                $fromName = SiteSetting::get('mail_from_name', env('MAIL_FROM_NAME', 'মুক্তাদার বইঘর'));

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
            }
        } catch (\Throwable $e) {
            // Safe fallback during early boot
        }
    }
}
