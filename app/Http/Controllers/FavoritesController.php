<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {

        $this->middleware('auth');
    }


    /**
     * @param Reply $reply
     */
    public function store(Reply $reply)
    {
        $reply->favorite();
    }
}
