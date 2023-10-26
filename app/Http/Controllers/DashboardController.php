<?php

namespace App\Http\Controllers;

class DashboardController extends Controller {
    //Dashboard pages route function

    public function dashboard() {
        return view('pages.dashboard.dashboard-page');
    }
}
