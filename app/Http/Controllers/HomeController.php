<?php

namespace App\Http\Controllers;

use App\Participation;
use App\Practise;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    protected $german_days = [
        0   => 'So.',
        1   => 'Mo.',
        2   => 'Di.',
        3   => 'Mi.',
        4   => 'Do.',
        5   => 'Fr.',
        6   => 'Sa.'
    ];
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
        $german_days = $this->german_days;


        return view('home');

        //return view('practise', compact('practise', 'birthdays','beer'));
        //return view('home',compact('practises','german_days'));
    }
}
