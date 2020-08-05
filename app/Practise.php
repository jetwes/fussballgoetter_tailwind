<?php
/**
 * Created by PhpStorm.
 * User: j.twesmann
 * Date: 18.09.2018
 * Time: 11:55
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Practise extends Model
{
    protected $guarded = [];
    protected $dates = ['date_of_practise'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function participators()
    {
        return $this->hasMany(Participation::class)->where('participate','=',1);
    }

    public function cancellations()
    {
        return $this->hasMany(Participation::class)->where('participate','=',0);
    }

    public function draw()
    {
        return $this->hasOne(Draw::class);
    }
}