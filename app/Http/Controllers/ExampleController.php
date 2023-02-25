<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homePage() {
        return view('homepage');
    }

    public function aboutPage() {
        return '<h1>About Page!</h1><a href="/">Back to home</a>';
    }
}
