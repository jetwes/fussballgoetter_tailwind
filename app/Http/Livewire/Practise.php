<?php

namespace App\Http\Livewire;

use App\Draw;
use App\Participation;
use App\Seat;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Practise as CurrentPractise;

class Practise extends Component
{
    /**
     * @var CurrentPractise|array
     */
    public $practise;

    /**
     * @var ?Collection|array
     */
    public $birthdays;

    /**
     * @var ?Participation|array
     */
    protected $beer;

    public $participation;

    public $places = 0;
    public $comment;

    public function updatedComment($comment)
    {
        if ($comment === '') $comment = null;
        $this->participation->comment = $comment;
        $this->participation->save();
    }

    public function takeSeat($id)
    {
        $seat = new Seat();
        $seat->driver_id = Participation::where('id',$id)->first()->user_id;
        $seat->user_id = Auth::user()->id;
        $seat->practise_id = $this->participation->practise_id;
        $seat->save();
    }

    public function leaveSeat($id)
    {
        Seat::where('user_id',Auth::id())->where('practise_id',$this->participation->practise_id)->delete();
    }

    public function updatedPlaces($places)
    {
        if($places === '') $places = 0;
        $this->participation->places = $places;
        if ($places > 0)
        {
            $seat = Seat::where('practise_id',$this->participation->practise_id)->where('driver_id',$this->participation->user_id)->first();
            if (!$seat) {
                $seat = new Seat();
                $seat->driver_id = Auth::user()->id;
                $seat->user_id = Auth::user()->id;
                $seat->practise_id = $this->participation->practise_id;
                $seat->save();
            }
        }
        $this->participation->save();
    }

    public function noDrive()
    {
        //$participation = Participation::where('id',$this->participation->id)->first();
        //$participation->places = 0;
        //$participation->comment = null;
        //$participation->save();
        $this->places = 0;
        $this->comment = null;
        $this->participation->places = 0;
        $this->participation->comment = null;
        Seat::where('practise_id',$this->participation->practise_id)->where('driver_id',$this->participation->user_id)->delete();
        $this->participation->save();
    }

    public function shuffle($id)
    {
        $practise = \App\Practise::where('id', '=', $id)->with('Participators')->first();
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
        session()->flash('success-message','Die Auslosung ist erfolgt!');
        //return view('shuffle',compact('teamA','teamB','teamC','teams','draw'));
    }

    /**
     * @param bool $participate
     */
    public function participate(bool $participate)
    {
        if ($this->participation) {
            $this->participation->participate = $participate;
            //reset beer if user is not participating
            if ($this->participation->beer && $participate === false)
                $this->participation->beer = false;
            if (!$participate) {
                $this->participation->places = 0;
                $this->participation->comment = null;
                Seat::where('practise_id',$this->participation->practise_id)->where('user_id',Auth::id())->delete();
            }
            $this->participation->save();
            if (!$participate)
                session()->flash('error-message','Du hast dich erfolgreich abgemeldet.');
            else
                session()->flash('success-message','Du hast dich erfolgreich angemeldet.');
        } else {
            Participation::create([
                'user_id' => auth()->id(),
                'practise_id' => $this->practise->id,
                'participate' => $participate,
            ]);
            session()->flash('success-message','Du hast dich erfolgreich angemeldet.');
        }
        $this->practise->load('participations');
        $this->practise->load('participators');
    }

    /**
     * @param bool $beer
     */
    public function setBeer(bool $beer)
    {
        $participation = Participation::where('practise_id',$this->practise->id)->where('user_id',auth()->id())->first();
        if ($participation) {
            if(!$participation->participate) {
                session()->flash('error-message','Du kannst kein Bier mitringen - du bist noch nicht angemeldet ;)');
                return;
            }
            $participation->beer = $beer;
            $participation->save();
            //thank the user
            if ($beer)
                session()->flash('success-message','DANKE! Du bringst Bier mit.');
            else
                session()->flash('error-message','Schade, du bringst doch kein Bier mit.');
        } else {
            Participation::create([
                'user_id' => auth()->id(),
                'practise_id' => $this->practise->id,
                'beer' => $beer,
                'participate'   => true
            ]);
        }
        $this->getBeer();
    }

    /**
     * @return CurrentPractise|array
     */
    public function getPractise()
    {
        $practise = CurrentPractise::where('date_of_practise','>=',Carbon::now()->subHours(4))->orderBy('date_of_practise','ASC')
            ->with(['participations','participators','seats','draw', 'cancellations'])
            ->limit(1)->first();
        if (!$practise)
            $practise = CurrentPractise::create([
                'name'              => 'Fussballgötter',
                'date_of_practise'  => Carbon::now()->startOfWeek()->addWeek()->setTime(19,00,00)
            ]);
        return $practise;
    }

    /**
     *
     */
    public function getBeer()
    {
        if ($this->practise)
           $this->beer = $this->practise->participations->where('beer',true)->first();
        else $this->beer = null;
    }

    /**
     * @return ?Collection
     */
    public function getBirthdays()
    {
        $birthdays = User::whereNotNull('birthday')->get();
        foreach($birthdays as $key => $birthday) {
            if ($birthday->birthday && !$birthday->birthday->isBirthday()) {
                if( ($birthday->birthday->day != Carbon::now()->addDays(1)->day && $birthday->birthday->day != Carbon::now()->addDays(2)->day && $birthday->birthday->day != Carbon::now()->addDays(3)->day
                        && $birthday->birthday->day != Carbon::now()->addDays(4)->day && $birthday->birthday->day != Carbon::now()->addDays(5)->day && $birthday->birthday->day != Carbon::now()->addDays(6)->day
                    ) || ($birthday->birthday->month != Carbon::now()->month || $birthday->birthday->day < Carbon::now()->day))
                    unset($birthdays[$key]);
            }
        }
        return $birthdays;
    }

    public function mount()
    {
        $this->practise = $this->getPractise();
        $this->birthdays = $this->getBirthdays();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {

        $this->getBeer();
        if ($this->practise && !$this->participation) {
           // dd(in_array(auth()->id(), $this->practise->participations->pluck('user_id')->toArray()));
            $this->participation = $this->practise->participations->where('user_id', auth()->id())->first();//Participation::where('practise_id', $this->practise->id)->where('user_id', auth()->id())->first();
            if($this->participation) {
                $this->places = $this->participation->places;
                $this->comment = $this->participation->comment;
            }
        }
        return view('livewire.practise', [
            //'practise'  => $this->practise,
            'beer'      => $this->beer,
            //'participation' => $this->participation
        ]);
    }
}
