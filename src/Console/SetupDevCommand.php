<?php

namespace Octo\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetupDevCommand extends Command
{
    protected $signature = 'app:dev';

    protected $description = 'Dev aplication';

    public const DEFAULT_USER_NAME = 'user';

    public const DEFAULT_USER_EMAIL = 'user@octo.dev';

    public const DEFAULT_USER_PASSWORD = '123456';

    public const DEFAULT_SUPER_ADMIN_NAME = 'admin';

    public const DEFAULT_SUPER_ADMIN_EMAIL = 'super-admin@octo.dev';

    public const DEFAULT_SUPER_ADMIN_PASSWORD = '123456';

    public function handle()
    {
        $this->info('Optimizing');
        $this->call('optimize');

        $this->call('migrate:fresh', ['--force' => true, '--seed' => true]);

        $this->info('Creating super admin account');
        $superAdmin = $this->setUpSuperAdminAccount();

        $this->info('Installing Shield');
        $this->call('shield:install', ['--fresh' => true, '--minimal' => true]);

        $this->info('Creating user account');
        $user = $this->setUpUserAccount();

        $this->info('Installing LogViewer');
        $this->call('log-viewer:publish');
    }

    private function setUpUserAccount()
    {
        $user = User::forceCreate([
            'name' => self::DEFAULT_USER_NAME,
            'email' => self::DEFAULT_USER_EMAIL,
            'password' => Hash::make(self::DEFAULT_USER_PASSWORD),
        ]);

        $user->markEmailAsVerified();

        $user->assignRole('user');

        $this->comment(sprintf('Log in user with email %s and password %s', self::DEFAULT_USER_EMAIL, self::DEFAULT_USER_PASSWORD));

        return $user;
    }

    private function setUpSuperAdminAccount()
    {
        $user = User::forceCreate([
            'name' => self::DEFAULT_SUPER_ADMIN_NAME,
            'email' => self::DEFAULT_SUPER_ADMIN_EMAIL,
            'password' => Hash::make(self::DEFAULT_SUPER_ADMIN_PASSWORD),
        ]);

        $user->markEmailAsVerified();

        $this->comment(sprintf('Log in user with email %s and password %s', self::DEFAULT_SUPER_ADMIN_EMAIL, self::DEFAULT_SUPER_ADMIN_PASSWORD));

        return $user;
    }

    public function factoryData()
    {
    }
}
