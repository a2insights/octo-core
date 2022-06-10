<?php

namespace Octo\System\Addons\Contracts;

interface AddonContract
{
    public function getName(): string;

    public function getVersion(): string;

    public function getRepositoryUrl(): string;

    public function markAsInstalled(): void;

    public function markAsUninstalled(): void;

    public function isInstalled(): bool;

    public function isVcs(): bool;
}
