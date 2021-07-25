<?php

namespace App\Models;

use App\Http\Requests\StoreMovieRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class Movie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_adress',
        'movie_title',
        'movie_path',
        'movie_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasmany(Favorite::class);
    }

    // アップロードした動画の情報を保存
    public function storeMovieInfo(StoreMovieRequest $request)
    {
        //s3アップロード開始
        $post_movie = $request->file('post_movie');
        // バケットへアップロード
        $s3_file_name = Storage::disk('s3')->put('/movie', $post_movie, 'public');

        return $this->create(array_merge(
            $request->all(),
            $this->processingFormDate($s3_file_name),
        ));
    }

    // データを加工
    private function processingFormDate(String $s3_file_name): array
    {
        return [
            'user_id'    => Auth::id(),
            'movie_path' => Storage::disk('s3')->url($s3_file_name),
        ];
    }

    // 検索条件があれば検索条件を加えたクエリーを生成
    private function searchConditionQuery(Request $request)
    {
        $query = $this->query();

        foreach ($request->all() as $key => $val) {
            // pageとbuttonはスキップ
            if ($key === 'page' || $key === 'button') {
                continue;
            }
            if ($key === 'email') {
                $val !== null ? $query->where($key, 'LIKE', '%' . $val . '%') : '';
            } else {
                $val !== null ? $query->where($key, $val) : '';
            }
        }
        return $query;
    }

    // 検索条件を含めたページャーを生成
    public function acquisitionMovieList(Request $request)
    {
        return $this->searchConditionQuery($request)->orderBy('id', 'ASC')->paginate(10);
    }

    public function acquisitionMovieInfomation(Int $id)
    {
        return $this->where('id', $id)->first();
    }
}
