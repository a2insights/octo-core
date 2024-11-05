<?php

namespace A2insights\FilamentSaas\Tenant\Actions\FilamentCompanies;

use A2insights\FilamentSaas\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Wallo\FilamentCompanies\Contracts\SetsUserPasswords;

class SetUserPassword implements SetsUserPasswords
{
    /**
     * Validate and update the user's password.
     */
    public function set(User $user, array $input): void
    {
        Validator::make($input, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validateWithBag('setPassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
