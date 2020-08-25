<?php

namespace App\Http\Livewire;

use App\Participation;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
    public $beer;

    /**
     * @param bool $participate
     */
    public function participate(bool $participate)
    {
        $participation = Participation::where('practise_id',$this->practise->id)->where('user_id',auth()->id())->first();
        if ($participation) {
            $participation->participate = $participate;
            $participation->save();
        } else {
            Participation::create([
                'user_id' => auth()->id(),
                'practise_id' => $this->practise->id,
                'participate' => $participate,
            ]);
        }
    }

    /**
     * @param bool $beer
     */
    public function setBeer(bool $beer)
    {
        $participation = Participation::where('practise_id',$this->practise->id)->where('user_id',auth()->id())->first();
        if ($participation) {
            $participation->beer = $beer;
            $participation->save();
        } else {
            Participation::create([
                'user_id' => auth()->id(),
                'practise_id' => $this->practise->id,
                'beer' => $beer,
            ]);
        }
        $this->getBeer();
    }

    /**
     * @return CurrentPractise|array
     */
    public function getPractise()
    {
        $practise = CurrentPractise::where('date_of_practise','>=',Carbon::now())->orderBy('date_of_practise','ASC')->with(['participations','participations.user','participators'])->limit(1)->first();
        if (!$practise)
            $practise = CurrentPractise::create([
                'name'              => 'Montagstruppe',
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
           $this->beer = Participation::where('practise_id',$this->practise->id)->where('beer',true)->first();
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
        $this->getBeer();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        if(count($this->propertyHashes) !== 0)
            $this->practise = $this->getPractise();
        return view('livewire.practise');
    }
}
