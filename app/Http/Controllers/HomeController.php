<?php

namespace App\Http\Controllers;

class HomeController extends Controller {

    public function homePage() {
        return view('home');
    }
}
