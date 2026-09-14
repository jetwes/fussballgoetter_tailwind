<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participation extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'participate' => 'boolean',
            'beer' => 'boolean',
            'places' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function practise(): BelongsTo
    {
        return $this->belongsTo(Practise::class);
    }
}
