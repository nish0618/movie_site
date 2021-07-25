<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'movie_title'       => 'required|string',
            'movie_description' => 'max:100',
            'post_movie'        => 'required|mimes:mp4,qt,x-ms-wmv,mpeg,x-msvideo'
        ];
    }

    public function messages()
    {
        return [
            'post_movie.required'  => 'アップロードファイルを選択してください。',
        ];
    }
}
