<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function subject()
    {
        return $this->morphTo();
    }
}
