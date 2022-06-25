<?php

namespace Octo\System\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('octo::system.dashboard.index', [
            'stats' => [
                [
                    'title' => __('Users'),
                    'count' => User::count(),
                    'icon' => 'heroicon-o-user-group',
                    'route' => route('system.users.index'),
                    'color' => 'primary',
                    'direction' => 'up',
                    // 'percent' => '10',
                ]
            ],
        ]);
    }
}
