<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Favorite extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'movie_id',
        'user_agent',
        'ip_adress',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    // アップロードした動画の情報を保存
    public function storeFavoriteInfo(Request $request)
    {
        return $this->create(array_merge(
            $request->all(),
        ));
    }

    // データを加工
    // private function processingFormDate(String $movie_id): array
    // {
    //     return [
    //         'user_id'  => Auth::id(),
    //         'movie_id' => $movie_id,
    //     ];
    // }
}
