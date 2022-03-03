<?php

namespace Octo\Http\Controllers;

use Illuminate\Routing\Controller;

class NotificationsController extends Controller
{
    public function index()
    {
        return view('octo::notifications.index');
    }
}
