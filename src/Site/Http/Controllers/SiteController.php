<?php

namespace A2Insights\FilamentSaas\Site\Http\Controllers;

use A2Insights\FilamentSaas\Features\Features;
use A2Insights\FilamentSaas\Settings\Settings;
use A2Insights\FilamentSaas\Settings\TermsSettings;
use A2Insights\FilamentSaas\Settings\WhatsappChatSettings;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;

class SiteController
{
    public function __construct(protected Settings $settings)
    {
        $tenantPath = config('filament-saas.tenant_path');
        $sysadminPath = config('filament-saas.sysadmin_path');
        $dashboardUrl = auth()?->user()?->hasRole('super_admin') ? url($sysadminPath) : url($tenantPath);
        $features = app(Features::class);
        $whatsappChatSettings = app(WhatsappChatSettings::class);

        Inertia::share('appName', config('app.name'));
        Inertia::share('laravelVersion', Application::VERSION);
        Inertia::share('phpVersion', PHP_VERSION);
        Inertia::share('tenantPath', $tenantPath);
        Inertia::share('sysadminPath', $sysadminPath);
        Inertia::share('brevoNewsletterUrl', config('services.brevo.newsletter_url'));
        Inertia::share('dashboardUrl', $dashboardUrl);
        Inertia::share('siteUrl', url(config('filament-saas.site_path')));
        Inertia::share('blogUrl', url(config('filament-saas.blog_path')));
        Inertia::share('termsOfServiceUrl', route('filament-saas::site.terms-of-service'));
        Inertia::share('privacyPolicyUrl', route('filament-saas::site.privacy-policy'));
        Inertia::share('settings', $settings);
        Inertia::share('features', $features);
        Inertia::share('whatsappChatSettings', $whatsappChatSettings);

        View::share('head', $settings->head);

        SEOTools::setDescription($settings->description);
        SEOMeta::setDescription($settings->description);
        SEOMeta::addKeyword($settings->keywords);
        JsonLd::addImage($settings->og ? Storage::url($settings->og) : url('/img/og.png'));
        OpenGraph::setUrl(url('/'));
        OpenGraph::addProperty('keywords', collect($settings->keywords)->implode(', '));
        OpenGraph::addImage($settings->og ? Storage::url($settings->og) : url('/img/og.png'));
    }

    public function home()
    {
        SEOTools::setTitle($this->settings->name);
        SEOMeta::setTitle($this->settings->name);
        View::share('title', $this->settings->name);

        return Inertia::render('Home');
    }

    public function termsOfService(TermsSettings $settings)
    {
        SEOTools::setTitle(__('filament-saas::default.terms-of-service.title'), false);
        SEOMeta::setTitle(__('filament-saas::default.terms-of-service.title'), false);
        View::share('title', __('filament-saas::default.terms-of-service.title'));

        return Inertia::render('TermsOfService', [
            'title' => __('filament-saas::default.terms-of-service.title'),
            'terms' => $this->buildTailwindClasses(str()->markdown($settings->service)),
        ]);
    }

    public function privacyPolicy(TermsSettings $settings)
    {
        SEOTools::setTitle(__('filament-saas::default.privacy-policy.title'), false);
        SEOMeta::setTitle(__('filament-saas::default.privacy-policy.title'), false);
        View::share('title', __('filament-saas::default.privacy-policy.title'));

        return Inertia::render('PrivacyPolicy', [
            'title' => __('filament-saas::default.privacy-policy.title'),
            'terms' => $this->buildTailwindClasses(str()->markdown($settings->privacy_policy)),
        ]);
    }

    private function buildTailwindClasses(string $html)
    {
        $html = str_replace('<h1', '<h1 class="mt-4 text-4xl font-semibold tracking-tight text-pretty sm:text-5xl"', $html);
        $html = str_replace('<h2', '<h2 class="mt-4 text-3xl font-semibold tracking-tight text-pretty sm:text-4xl"', $html);
        $html = str_replace('<h3', '<h3 class="mt-4 text-2xl font-semibold tracking-tight text-pretty sm:text-3xl"', $html);
        $html = str_replace('<h4', '<h4 class="mt-4 text-xl font-semibold tracking-tight text-pretty sm:text-2xl"', $html);
        $html = str_replace('<h5', '<h5 class="mt-4 text-lg font-semibold tracking-tight text-pretty sm:text-xl"', $html);
        $html = str_replace('<h6', '<h6 class="mt-4 text-base font-semibold tracking-tight text-pretty sm:text-lg"', $html);
        $html = str_replace('<p', '<p class="mt-2"', $html);
        $html = str_replace('<li', '<li class="mt-2"', $html);
        $html = str_replace('<ul', '<ul class="ml-4 list-disc"', $html);
        $html = str_replace('<ol', '<ol class="pl-5 list-decimal"', $html);
        $html = str_replace('<a', '<a class=""', $html);
        $html = str_replace('<strong', '<strong class="font-semibold"', $html);
        $html = str_replace('<em', '<em class="italic"', $html);
        $html = str_replace('<code', '<code class="font-mono text-sm"', $html);
        $html = str_replace('<span', '<span class=""', $html);

        return $html;
    }
}
