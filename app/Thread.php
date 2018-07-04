<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    public $perPage = 20;

    protected $guarded = [];
    protected $with = ['creator','channel'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static ::addGlobalScope('replyCount',function($builder){
            $builder->withCount('replies');
        });
        // App\Thread::withoutGlobalScopes()->first();
        // static::addGlobalScope('creator', function ($builder) {
        //     $builder->with('creator');
        // });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
            // ->withCount('favorites')
            // ->with('owner');
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * @return mixed
     */
    public function creatorName()
    {
        return $this->creator->name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @param $reply
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }


    /**
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}
