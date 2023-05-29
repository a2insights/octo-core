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

    public function handle()
    {
        $this->call('migrate:fresh', ['--force' => true, '--seed' => true]);

        $this->info('Creating user account');
        $user = $this->setUpUserAccount();
        $this->info('User account created');
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

    public function factoryData()
    {
    }
}
