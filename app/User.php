<?php

namespace App;

use App\Http\Requests\Authorize;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use QCod\ImageUp\HasImageUploads;

class User extends Authenticatable
{
    use Notifiable;
    use HasImageUploads;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * All the images fields for model
     *
     * @var array
     */
    protected static $imageFields = [
        'avatar' => [
            'placeholder' => 'https://api.adorable.io/avatars/160',
            'width' => 240,
            'height' => 240,
            'resize_image_quality' => 90,
            'crop' => true,
            // what disk you want to upload, default config('imageup.upload_disk')
            'disk' => 'profile',
            // a folder path on the above disk, default config('imageup.upload_directory')
            'path' => '/user/avatars',
        ]
    ];

    protected $dates = ['birthday'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function participations()
    {
        return $this->hasMany(Practise::class);
    }
}
