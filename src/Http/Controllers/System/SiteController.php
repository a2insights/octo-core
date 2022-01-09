<?php

namespace Octo\Http\Controllers\System;

use Illuminate\Routing\Controller;

class SiteController extends Controller
{
    public function index()
    {
        return view('octo::livewire.system.site.index');
    }
}
