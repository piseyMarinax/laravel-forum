<?php
/**
 * Created by PhpStorm.
 * User: mp001
 * Date: 7/14/18
 * Time: 1:31 AM
 */

namespace App;


trait RecodesActivity
{

    protected static function bootRecodesActivity()
    {
        if(auth()->guest()) return;

        foreach (static::getRecodeEvent() as $event) {
            static::$event(function ($model) use ($event){
                $model->recodeActivity($event);
            });
        }
    }

    protected static function getRecodeEvent()
    {
        // fire event
        return ['created','deleted'];
    }

    protected function recodeActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity','subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}