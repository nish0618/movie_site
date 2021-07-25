<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    private $favorite;

    public function __construct(Favorite $favorite)
    {
        $this->favorite = $favorite;
    }

    public function store(Request $request)
    {
    }

    public function destroy()
    {
    }
}
