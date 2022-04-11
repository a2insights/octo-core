<?php

namespace Octo\Console;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Console\Command;
use Octo\Marketing\Models\Campaign;
use Octo\Marketing\Models\Contact;
use Octo\Marketing\Stats\CampaignStats;
use Octo\Marketing\Stats\ContactStats;

class SetupDemoCommand extends Command
{
    protected $signature = 'octo:demo';

    protected $description = 'Setup demo aplication';

    public const DEFAULT_SUPER_ADMIN_NAME = 'Octo Super Administrator';
    public const DEFAULT_SUPER_ADMIN_EMAIL = 'super-admin@octo.dev';
    public const DEFAULT_SUPER_ADMIN_PASSWORD = 'octoSuperAdmin';

    public const DEFAULT_USER_NAME = 'Octo User';
    public const DEFAULT_USER_EMAIL = 'user@octo.dev';
    public const DEFAULT_USER_PASSWORD = 'octoUser';

    public function handle()
    {
        try {
            \App\Models\Tenant::all()->each(function ($tenant) {
                $tenant->delete();
            });
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->call('migrate:fresh', ['--force' => true, '--seed' => true]);

        $this->info('Creating super admin user');
        $admin = $this->setUpAdminAccount();
        $this->info('Super admin user created');

        $this->info('Creating user account');
        $user = $this->setUpUserAccount();
        $this->info('User account created');

        $this->info('Seeding fake data in database');

        $admin->tenant->run(function () {
            $this->factoryData();
        });

        $user->tenant->run(function () {
            $this->factoryData();
        });
    }

    private function setUpUserAccount()
    {
        $user = (new CreateNewUser())->create([
            'name' => self::DEFAULT_USER_NAME,
            'email' => self::DEFAULT_USER_EMAIL,
            'password' => self::DEFAULT_USER_PASSWORD,
            'password_confirmation' => self::DEFAULT_USER_PASSWORD,
            'terms' => true,
        ]);

        $user->currentSubscription->recordFeatureUsage('contacts', 49);

        $user->markEmailAsVerified();

        $this->comment(sprintf('Log in user with email %s and password %s', self::DEFAULT_USER_EMAIL, self::DEFAULT_USER_PASSWORD));

        return $user;
    }

    private function setUpAdminAccount()
    {
        $user = (new CreateNewUser())->create([
            'name' => self::DEFAULT_SUPER_ADMIN_NAME,
            'email' => self::DEFAULT_SUPER_ADMIN_EMAIL,
            'calling_code' => '55',
            'phone' => '91 989242304',
            'password' => self::DEFAULT_SUPER_ADMIN_PASSWORD,
            'password_confirmation' => self::DEFAULT_SUPER_ADMIN_PASSWORD,
            'terms' => true,
        ]);

        $user->forceFill(['super_admin' => true,  'dashboard' => 'system'])->save();

        $user->markEmailAsVerified();

        $user->currentSubscription->recordFeatureUsage('contacts', 49);

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
