<?php

namespace Octo\System\Http\Controllers;

use Illuminate\Routing\Controller;

class SiteController extends Controller
{
    public function index()
    {
        return view('octo::system.site.index');
    }
}
