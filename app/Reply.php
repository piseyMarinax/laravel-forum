<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
    
    public function __constructor()
    {
        $this->middleware('auth');
    }
    
    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
