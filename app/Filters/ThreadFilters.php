<?php


namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{

    protected $filters = ['by','popular'];

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

    /**
     * Filter the query according to most popular thread
     * @return mixed
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'dec');
    }

}