<?php

namespace App\Http\Controllers;

class Orders extends Controller implements IndexInterface
{
    public function indexAction()
    {
        return view('orders.index');
    }
}