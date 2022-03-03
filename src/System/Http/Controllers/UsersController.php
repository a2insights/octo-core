<?php

namespace Octo\System\Http\Controllers;

use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    public function index()
    {
        return view('octo::system.users.index');
    }
}
