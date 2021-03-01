<?php

namespace Octo;

use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Octo\Resources\Components\material\CardMaterial;
use Octo\Resources\Components\material\CounterMaterial;
use Octo\Resources\Components\material\NavMaterial;
use Octo\Resources\Components\material\SidebarMaterial;
use Octo\Resources\Components\tailwind\SidebarTailwind;

trait ComponentsProvider
{
    /**
     * Register all octo components.
     *
     * @return void
     */
    private function registerComponentsProviders()
    {
        $this->callAfterResolving(BladeCompiler::class, function () {
            $this->registerTailwindComponents('tailwind');
            $this->registerMaterialComponents('material');
            $this->registerJetStreamComponents('tailwind.jetstream');
        });
    }

    /**
     * Register all tailwind components.
     *
     * @param $path
     * @return void
     */
    private function registerTailwindComponents($path)
    {
        collect([
            'sidebar' => SidebarTailwind::class,
        ])->each(
            fn($class, $component) => $this->registerComponent("$path-$component", $class)
        );
    }

    /**
     * Register all material components.
     *
     * @param $path
     * @return void
     */
    private function registerMaterialComponents($path)
    {
        collect([
            'nav' => NavMaterial::class,
            'sidebar' => SidebarMaterial::class,
            'card' => CardMaterial::class,
            'counter' => CounterMaterial::class
        ])->each(
            fn($class, $component) => $this->registerComponent("$path-$component", $class)
        );
    }

    /**
     * Register and wrapper all jetstream components.
     *
     * @param $path
     * @return void
     */
    protected function registerJetStreamComponents($path)
    {
        collect([
            'action-message' , 'action-section', 'application-logo', 'application-mark',
            'authentication-card', 'authentication-card-logo', 'banner', 'button',
            'confirmation-modal', 'confirms-password', 'danger-button', 'dialog-modal',
            'dropdown', 'dropdown-link', 'form-section', 'input', 'checkbox', 'input-error',
            'modal', 'nav-link', 'responsive-nav-link', 'responsive-switchable-team',
            'secondary-button', 'section-border', 'section-title', 'switchable-team',
            'validation-errors' , 'welcome'
        ])->map(
            fn($component) => $this->registerComponent($component, "components.$path")
        );
    }

    /**
     * Register the given component.
     *
     * @param string $component
     * @param $namespace
     * @return void
     */
    protected function registerComponent(string $component, $namespace)
    {
        $directiveName = 'octo-'.$component;

        class_exists($namespace) ?
            Blade::component($directiveName, $namespace) :
            Blade::component("octo::$namespace.$component", $directiveName);
    }


}
