<?php

namespace App\Http\Controllers;

class Dashboard extends Controller
{
    public function indexAction() {
        return view('dashboard');
    }

}