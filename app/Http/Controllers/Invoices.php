<?php

namespace App\Http\Controllers;

class Invoices extends Controller implements IndexInterface
{
    public function indexAction()
    {
        return view('invoices.index');
    }
}