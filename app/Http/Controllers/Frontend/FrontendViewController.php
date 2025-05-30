<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendViewController extends Controller
{
    public function homePage()
    {
        return view('frontend.home-landing');
    }
}
