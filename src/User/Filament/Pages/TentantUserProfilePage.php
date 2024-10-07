<?php

namespace Octo\User\Filament\Pages;

use Jeffgreco13\FilamentBreezy\Pages\MyProfilePage;

/**
 * @property Form $form
 */
class TentantUserProfilePage extends MyProfilePage
{
    protected static string $view = 'octo::pages.tenant-user-profile';
}
