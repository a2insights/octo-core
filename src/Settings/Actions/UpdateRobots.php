<?php

namespace A2Insights\FilamentSaas\Settings\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class UpdateRobots
{
    use AsAction;

    /**
     * Generates the sitemap based on the application settings.
     */
    public function handle(string $newContent): void
    {
        $publicFilePath = public_path('robots.txt');

        file_put_contents($publicFilePath, $newContent);
    }
}
