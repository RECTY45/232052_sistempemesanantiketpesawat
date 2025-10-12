<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashController extends Controller
{
    public function dash(){
        return view('dashboard.dash',[
            'title' => 'Travelo',
        ]);
    }
}
