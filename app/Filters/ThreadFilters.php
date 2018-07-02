<?php


namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{

    protected $filters = ['by'];

    /**
     * Filter query given by username
     * @param string $userName
     * @return mixed
     */
    protected function by($userName)
    {
        $user = User::where('name', $userName)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

}