<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        //
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $userLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        } else {
            $userLanguage = 'en'; // Standardsprache festlegen, falls der Header nicht verfügbar ist
        }

        $supportedLanguages = ['en', 'es', 'de']; // Liste der unterstützten Sprachen

        if (in_array($userLanguage, $supportedLanguages)) {
            App::setLocale($userLanguage);
        } else {
            App::setLocale('en'); // Standardsprache, falls die bevorzugte Sprache nicht unterstützt wird
        }
        Paginator::useBootstrap();


        Blade::directive('videoThumbnail', function ($expression) {
            return "<?php echo !empty($expression) ? asset('videos/' . $expression) : asset('/img/s1.png'); ?>";
        });


        View::composer('layouts.app', function ($view) {
            $channelImage = null;

            if (auth()->check() && auth()->user()->channel) {
                $channelImage = auth()->user()->channel->getPictureAttribute();
            }

            $view->with('channelImage', $channelImage);
        });

    }
}
