<?php
/**
 * Created by PhpStorm.
 * User: j.twesmann
 * Date: 18.09.2018
 * Time: 12:14
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class Seat extends Model
{

    protected $table = 'seats';
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(User::class,'driver_id','id');
    }

    public function practise()
    {
        return $this->belongsTo(Practise::class);
    }

}
