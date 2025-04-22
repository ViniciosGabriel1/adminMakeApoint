<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicesController extends Controller
{
    //

    public function index(){
        // dd(auth());
        return view('services.index');
    }
}
