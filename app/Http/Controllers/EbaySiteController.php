<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EbaySiteController extends Controller
{
    //
    public function index()
    {
        return view('ebay-site/index');
    }

    public function add()
    {
        return "add";
    }
}
