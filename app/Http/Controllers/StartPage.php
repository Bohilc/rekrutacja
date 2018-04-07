<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StartPage extends Controller
{
    public function index() {
        return view('startPage.index');
    }
}
