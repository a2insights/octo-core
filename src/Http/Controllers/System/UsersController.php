<?php

namespace Octo\Http\Controllers\System;

use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    public function index()
    {
        return view('octo::livewire.system.users.index');
    }
}