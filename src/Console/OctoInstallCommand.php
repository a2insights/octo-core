<?php

namespace Octo\Console;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Octo\Octo;

class OctoInstallCommand extends Command
{
    protected $signature = 'octo:install';

    protected $description = 'Install aplication';

    public const DEFAULT_USER_NAME = 'user';

    public const DEFAULT_USER_EMAIL = 'user@octo.dev';

    public const DEFAULT_USER_PASSWORD = '123456';

    public const DEFAULT_ADMIN_NAME = 'admin';

    public const DEFAULT_ADMIN_EMAIL = 'admin@octo.dev';

    public const DEFAULT_ADMIN_PASSWORD = '123456';

    public const DEFAULT_SUPER_ADMIN_NAME = 'super_admin';

    public const DEFAULT_SUPER_ADMIN_EMAIL = 'super_admin@octo.dev';

    public const DEFAULT_SUPER_ADMIN_PASSWORD = '123456';

    public function handle()
    {
        $this->info('Optimizing');
        $this->call('optimize');

        Config::set('app.timezone', 'America/Sao_Paulo');
        date_default_timezone_set('America/Sao_Paulo');

        $this->call('migrate:fresh', ['--force' => true, '--seed' => true]);

        $this->info('Installing Shield');
        $this->call('shield:install', ['--fresh' => true, '--minimal' => true, '--only' => true]);

        $this->call('shield:generate', [
            '--all' => true,
            '--minimal' => true,
        ]);

        $this->info('Creating super admin account');
        $superAdmin = $this->setUpSuperAdminAccount();

        $this->info('Creating admin account');
        $admin = $this->setUpAdminAccount();

        $this->info('Creating user account');
        $user = $this->setUpUserAccount();

        $this->info('Installing LogViewer');
        $this->call('log-viewer:publish');
    }

    private function setUpSuperAdminAccount()
    {
        $user = Octo::getUserModel()::forceCreate([
            'name' => self::DEFAULT_SUPER_ADMIN_NAME,
            'email' => self::DEFAULT_SUPER_ADMIN_EMAIL,
            'password' => Hash::make(self::DEFAULT_SUPER_ADMIN_PASSWORD),
        ]);

        $user->markEmailAsVerified();

        $superAdminRole = Utils::getRoleModel()::firstOrCreate(
            ['name' => Utils::getSuperAdminName()],
            ['guard_name' => Utils::getFilamentAuthGuard()]
        );

        $user->assignRole(Utils::getSuperAdminName());

        $this->comment(sprintf('Log in user with email %s and password %s', self::DEFAULT_SUPER_ADMIN_EMAIL, self::DEFAULT_SUPER_ADMIN_PASSWORD));

        return $user;
    }

    private function setUpAdminAccount()
    {
        $user = Octo::getUserModel()::forceCreate([
            'name' => self::DEFAULT_ADMIN_NAME,
            'email' => self::DEFAULT_ADMIN_EMAIL,
            'password' => Hash::make(self::DEFAULT_ADMIN_PASSWORD),
        ]);

        $user->markEmailAsVerified();

        $adminRole = Utils::getRoleModel()::firstOrCreate(
            ['name' => 'admin'],
            ['guard_name' => Utils::getFilamentAuthGuard()]
        );

        $adminRole->syncPermissions([]);

        $user->assignRole('admin');

        $this->comment(sprintf('Log in user with email %s and password %s', self::DEFAULT_ADMIN_EMAIL, self::DEFAULT_ADMIN_PASSWORD));

        return $user;
    }

    private function setUpUserAccount()
    {
        $user = Octo::getUserModel()::forceCreate([
            'name' => self::DEFAULT_USER_NAME,
            'email' => self::DEFAULT_USER_EMAIL,
            'password' => Hash::make(self::DEFAULT_USER_PASSWORD),
        ]);

        $user->markEmailAsVerified();

        $userRole = Utils::getRoleModel()::firstOrCreate(
            ['name' => Utils::getPanelUserRoleName()],
            ['guard_name' => Utils::getFilamentAuthGuard()]
        );

        $userRole->syncPermissions([]);

        $user->assignRole(Utils::getPanelUserRoleName());

        $this->comment(sprintf('Log in user with email %s and password %s', self::DEFAULT_USER_EMAIL, self::DEFAULT_USER_PASSWORD));

        return $user;
    }

    public function factoryData()
    {
    }
}
