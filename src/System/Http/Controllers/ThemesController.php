<?php

namespace Octo\System\Http\Controllers;

use Illuminate\Routing\Controller;

class ThemesController extends Controller
{
    public function index()
    {
        return view('octo::system.themes.index');
    }
}
