<?php

namespace Octo\System\Addons\Contracts;

interface AddonContract
{
    public function getName(): string;

    public function getRepositoryName(): string;

    public function getRepositoryUrl(): string;

    public function install(): void;

    public function uninstall(): void;

    public function isInstalled(): bool;

    public function isVcs(): bool;
}
