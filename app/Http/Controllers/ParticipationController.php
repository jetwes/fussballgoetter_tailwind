<?php
/**
 * Created by PhpStorm.
 * User: j.twesmann
 * Date: 18.09.2018
 * Time: 12:23
 */

namespace App\Http\Controllers;

use App\Draw;
use App\Participation;
use App\User;
use App\Practise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipationController extends Controller
{

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $practises = Practise::where('date_of_practise', '>=', Carbon::now())->orderBy('date_of_practise', 'ASC')->with('Participators')->with('Cancellations')->limit(4)->get();
        return dd($practises);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function detail($id, Request $request)
    {
        if ($request->has('participate')) {
            $participation = Participation::where('user_id', '=', Auth::user()->id)->where('practise_id','=',$id)->first();
            if ($participation) {
                $participation->participate = $request->get('participate');
                $participation->save();
            } else {
                Participation::create([
                    'user_id' => Auth::user()->id,
                    'practise_id' => $id,
                    'participate' => $request->get('participate'),

                ]);
            }
        }
        if ($request->has('beer')) {
            $participation = Participation::where('user_id', '=', Auth::user()->id)->where('practise_id','=',$id)->first();
            if ($participation) {
                $participation->beer = true;
                $participation->save();
            } else {
                Participation::create([
                    'user_id' => Auth::user()->id,
                    'practise_id' => $id,
                    'participate' => $request->get('participate'),
                    'beer'        => true,
                ]);
            }
        }
        $practise = Practise::where('id', '=', $id)->with(['participations','participators','participations.user'])->first();
        if ($practise->date_of_practise < Carbon::now())
            return redirect(route('home'));
        if ($practise)
            $beer = Participation::where('practise_id',$practise->id)->where('beer',true)->first();
        else $beer = null;
        $birthdays = User::whereNotNull('birthday')->get();
        foreach($birthdays as $key => $birthday) {
            if ($birthday->birthday && !$birthday->birthday->isBirthday()) {
                if( ($birthday->birthday->day != Carbon::now()->addDays(1)->day && $birthday->birthday->day != Carbon::now()->addDays(2)->day && $birthday->birthday->day != Carbon::now()->addDays(3)->day
                    && $birthday->birthday->day != Carbon::now()->addDays(4)->day && $birthday->birthday->day != Carbon::now()->addDays(5)->day && $birthday->birthday->day != Carbon::now()->addDays(6)->day
                    ) || ($birthday->birthday->month != Carbon::now()->month || $birthday->birthday->day < Carbon::now()->day))
                    unset($birthdays[$key]);
            }
        }
        return view('practise', compact('practise','birthdays','beer'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shuffle($id)
    {
        $practise = Practise::where('id', '=', $id)->with('Participators')->first();
        //check if theres a shuffle already
        $draw = Draw::where('practise_id',$id)->first();
        if ($draw) {
            $teamA = $draw->teamA;
            $teamB = $draw->teamB;
            $teamC = $draw->teamC;
            $teams[] = explode(',',$teamA);
            $teams[] = explode(',',$teamB);
            $teams[] = explode(',',$teamC);
            return view('shuffle',compact('teamA','teamB','teamC','teams','draw'));
        }

        //if there is no draw - do it
        $names = [];
        if ($practise)
            foreach ($practise->participators as $participator) {
                array_push($names, $participator->User->name);
            }
        $shuffle = $names;
        shuffle($shuffle); //shuffle the names
        if (count($shuffle) >= 15)
            $tile = round(count($shuffle) / 3, 0); // split into 3 teams
        else
            $tile = round(count($shuffle) / 2, 0); // split into 2 teams

        $teams = array_chunk($shuffle, $tile);
        $teamA = '';
        $teamB = '';
        $teamC = '';
        foreach($teams[0] as $player) {
            $teamA .= $player.',';
        }
        foreach($teams[1] as $player) {
            $teamB .= $player.',';
        }
        if (count($shuffle) >= 15) {
            foreach($teams[2] as $player) {
                $teamC .= $player.',';
            }
        } else $teamC = null;
        //create the teams in the database
        $draw = Draw::create([
            'practise_id' => $id,
            'teamA'         => $teamA,
            'teamB'         => $teamB,
            'teamC'         => $teamC,
            'drawer_id'     => Auth::user()->id
        ]);
        return view('shuffle',compact('teamA','teamB','teamC','teams','draw'));
    }
}
