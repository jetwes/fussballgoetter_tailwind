<?php

namespace App\Http\Controllers;

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
        $practise = Practise::where('date_of_practise','>=',Carbon::now())->orderBy('date_of_practise','ASC')->with(['participations','participations.user','participators','cancellations'])->limit(1)->first();
        //dd($practise);
        $birthdays = User::whereNotNull('birthday')->get();
        foreach($birthdays as $key => $birthday) {
            if ($birthday->birthday && !$birthday->birthday->isBirthday()) {
                if( ($birthday->birthday->day != Carbon::now()->addDays(1)->day && $birthday->birthday->day != Carbon::now()->addDays(2)->day && $birthday->birthday->day != Carbon::now()->addDays(3)->day
                && $birthday->birthday->day != Carbon::now()->addDays(4)->day && $birthday->birthday->day != Carbon::now()->addDays(5)->day && $birthday->birthday->day != Carbon::now()->addDays(6)->day
                ) || ($birthday->birthday->month != Carbon::now()->month || $birthday->birthday->day < Carbon::now()->day))
                    unset($birthdays[$key]);
            }
        }

        return view('practise', compact('practise', 'birthdays'));
        //return view('home',compact('practises','german_days'));
    }
}
