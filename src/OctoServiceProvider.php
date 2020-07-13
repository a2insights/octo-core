<?php

namespace Octo;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Octo\Resources\Navigation\NavMaterial;
use Octo\Resources\Navigation\SidebarMaterial;
use Octo\Resources\Components\CardMaterial;
use Octo\Resources\Components\CounterMaterial;

class OctoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/octo.php' => config_path('octo.php'),
        ], 'octo/config');

        $this->loadViewsFrom(__DIR__.'/views' , 'octo');

        Blade::component('octo-nav-material', NavMaterial::class);

        Blade::component('octo-sidebar-material', SidebarMaterial::class);

        Blade::component('octo-card-material', CardMaterial::class);

        Blade::component('octo-counter-material', CounterMaterial::class);

        Blade::directive('notify_render', function () {
            return "<?php echo app('notify')->render(); ?>";
        });

        Blade::directive('notify_css', function () {
            return '<?php echo notify_css(); ?>';
        });

        Blade::directive('notify_js', function () {
            return '<?php echo notify_js(); ?>';
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/octo.php', 'octo'
        );
    }
}
