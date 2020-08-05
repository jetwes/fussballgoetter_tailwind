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

class Participation extends Model
{

    protected $table = 'participations';
    protected $guarded = [];

    protected $casts = [
        'participate' => 'boolean'
    ];


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
    public function practise()
    {
        return $this->belongsTo(Practise::class);
    }

}