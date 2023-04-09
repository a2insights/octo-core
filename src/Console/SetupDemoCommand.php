<?php

namespace Octo\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Octo\Marketing\Models\Campaign;
use Octo\Marketing\Models\Contact;
use Octo\Marketing\Stats\CampaignStats;
use Octo\Marketing\Stats\ContactStats;

class SetupDemoCommand extends Command
{
    protected $signature = 'octo:demo';

    protected $description = 'Setup demo aplication';

    private $tenant;

    public const DEFAULT_SUPER_ADMIN_NAME = 'Octo Super Administrator';
    public const DEFAULT_SUPER_ADMIN_EMAIL = 'super-admin@octo.dev';
    public const DEFAULT_SUPER_ADMIN_PASSWORD = 'octoSuperAdmin';

    public const DEFAULT_USER_NAME = 'Octo User';
    public const DEFAULT_USER_EMAIL = 'user@octo.dev';
    public const DEFAULT_USER_PASSWORD = 'octoUser';

    public function handle()
    {
        $this->call('migrate:fresh', ['--force' => true, '--seed' => true]);

        $this->info('Creating super admin user');
        $admin = $this->setUpSuperAdminAccount();
        $this->info('Super admin user created');

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
        $contacts = Contact::factory()->count(49)->create();
        $campaings = Campaign::factory()->count(10)->create();

        $contacts->each(fn (Contact $c) => ContactStats::increase(1, $c->created_at));
        $campaings->each(fn (Campaign $c) => CampaignStats::increase(1, $c->created_at));
    }
}
