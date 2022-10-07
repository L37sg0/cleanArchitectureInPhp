<?php

namespace App\Http\Controllers;

class Customers extends Controller implements IndexInterface
{
    public function indexAction()
    {
        return view('customers.index');
    }
}