<?php

namespace Octo\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetupDevCommand extends Command
{
    protected $signature = 'app:dev';

    protected $description = 'Dev aplication';

    public const DEFAULT_SUPER_ADMIN_NAME = 'Octo Super Administrator';
    public const DEFAULT_SUPER_ADMIN_EMAIL = 'super-admin@octo.dev';
    public const DEFAULT_SUPER_ADMIN_PASSWORD = 'octoSuperAdmin';

    public const DEFAULT_ADMIN_NAME = 'Octo Administrator';
    public const DEFAULT_ADMIN_EMAIL = 'admin@octo.dev';
    public const DEFAULT_ADMIN_PASSWORD = 'octoAdmin';

    public const DEFAULT_USER_NAME = 'Octo User';
    public const DEFAULT_USER_EMAIL = 'user@octo.dev';
    public const DEFAULT_USER_PASSWORD = 'octoUser';

    public function handle()
    {
        $this->call('migrate:fresh', ['--force' => true, '--seed' => true]);

        $this->info('Creating super admin user');
        $admin = $this->setUpSuperAdminAccount();
        $this->info('Super admin user created');

        $this->info('Creating admin user');
        $admin = $this->setUpAdminAccount();
        $this->info('Admin user created');

        $this->info('Creating user account');
        $user = $this->setUpUserAccount();
        $this->info('User account created');
    }

    private function setUpAdminAccount()
    {
        $user = User::forceCreate([
            'name' => self::DEFAULT_ADMIN_NAME,
            'email' => self::DEFAULT_ADMIN_EMAIL,
            'password' => Hash::make(self::DEFAULT_USER_PASSWORD),
        ]);

        $user->markEmailAsVerified();

        $this->comment(sprintf('Log in admin with email %s and password %s', self::DEFAULT_ADMIN_EMAIL, self::DEFAULT_ADMIN_PASSWORD));

        return $user;
    }

    private function setUpUserAccount()
    {
        $user = User::forceCreate([
            'name' => self::DEFAULT_USER_NAME,
            'email' => self::DEFAULT_USER_EMAIL,
            'password' => Hash::make(self::DEFAULT_USER_PASSWORD),
        ]);

        $user->markEmailAsVerified();

        $this->comment(sprintf('Log in user with email %s and password %s', self::DEFAULT_USER_EMAIL, self::DEFAULT_USER_PASSWORD));

        return $user;
    }

    private function setUpSuperAdminAccount()
    {
        $user = User::forceCreate([
            'name' => self::DEFAULT_SUPER_ADMIN_NAME,
            'email' => self::DEFAULT_SUPER_ADMIN_EMAIL,
            'password' => Hash::make(self::DEFAULT_USER_PASSWORD),
        ]);

        $user->markEmailAsVerified();

        $this->comment(sprintf('Log in seper admin with email %s and password %s', self::DEFAULT_SUPER_ADMIN_EMAIL, self::DEFAULT_SUPER_ADMIN_PASSWORD));

        return $user;
    }

    public function factoryData()
    {
    }
}
