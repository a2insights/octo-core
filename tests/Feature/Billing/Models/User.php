<?php

namespace Octo\Tests\Feature\Billing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Octo\Tests\Feature\Billing\Database\Factories\UserFactory;

class User extends Authenticatable
{
    use Billable;
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
