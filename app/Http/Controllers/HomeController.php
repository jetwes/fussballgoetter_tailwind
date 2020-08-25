<?php

namespace App\Http\Controllers;

use App\Participation;
use App\Practise;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /*
         * we do all stuff in livewire
         */
        return view('home');

    }
}
