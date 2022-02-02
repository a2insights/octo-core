<?php

namespace Octo\Http\Controllers\System;

use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('octo::livewire.system.dashboard.index', [
            'stats' => [
                [
                    'title' => __('Users'),
                    'count' => User::count(),
                    'icon' => 'heroicon-o-user-group',
                    'route' => route('system.users.index'),
                    'color' => 'primary',
                    'direction' => 'up',
                    'percent' => '10',
                ]
            ],
        ]);
    }
}
