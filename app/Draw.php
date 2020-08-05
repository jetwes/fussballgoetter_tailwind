<?php
/**
 * Created by PhpStorm.
 * User: j.twesmann
 * Date: 25.09.2018
 * Time: 16:11
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{

    protected $table = 'draws';

    protected $guarded = [];

    public function practise()
    {
        return $this->belongsTo(Practise::class);
    }

    public function drawer()
    {
        return $this->belongsTo(User::class,'drawer_id','id');
    }

}