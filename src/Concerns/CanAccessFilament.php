<?php

namespace Octo\Concerns;

trait CanAccessFilament
{
    public function canAccessFilament(): bool
    {
        $settings = app(\Octo\Settings\Settings::class);

        return ! in_array($this->id, $settings->restrict_users);
    }
}
