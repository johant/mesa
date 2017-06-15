<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
      $Users =  User::all();

      return view('dashboard', compact('Users', 'ticketsPending', 'tickets'));
    }
}
