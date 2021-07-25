<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Models\Movie;
use DB;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    public function __construct(Movie $movie)
    {
        $this->middleware('auth');
        $this->movie = $movie;
    }

    public function index(Request $request)
    {
        return view('movie.index', [
            'movies' => $this->movie->acquisitionMovieList($request),
        ]);
    }

    public function create()
    {
        return view('movie.create');
    }

    public function store(StoreMovieRequest $request, Movie $movie)
    {
        // ファイル名取得
        // $file_name = $request->file('post_movie')->getClientOriginalName();

        // if (!file_exists(storage_path() . '/app/public/post_movie/' . $file_name)) {
        $results = DB::transaction(function () use ($request, $movie) {
            // フォーム内容を保存
            $form_data = $movie->storeMovieInfo($request);
            return [
                $form_data,
            ];
        });
        try {
            if (!$results) {
                throw new \Exception('入力情報の保存に失敗しました');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', $e->getMessage());
            return redirect()->route('movie.create');
        }

        return redirect()->route('movie.create')->with('flash_message', '投稿が完了しました');
        // } else {
        //     return redirect()->route('movie.create')->with('flash_message', 'すでに動画がアップされています。');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('movie.show', [
            'movie' => $this->movie->acquisitionMovieInfomation($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
