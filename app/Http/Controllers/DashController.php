<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashController extends Controller
{
    public function dash(){
        return view('dashboard.dash',[
            'title' => 'Travelo',
            'name' =>  'Travelo',
            'users' => User::count(),
        ]);
    }
}
