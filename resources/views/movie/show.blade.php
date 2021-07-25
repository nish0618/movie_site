@extends('layouts.app')
@section('content')

<a href='{{ route('movie.index') }}'><button class="btn btn-outline-info">一覧に戻る</button></a>
<div class="container mt-5">
    <div class="header">
        <h1>動画詳細</h1>
    </div>
    @if (!empty($movie))
        <div>
            {{ $movie->movie_title }}
        </div>
        <div>
            <video src='{{ $movie->movie_path }}' controls width="700px" height="400px"></video>
        </div>
        <div>
            {{ $movie->movie_description }}
        </div>
        {{-- <div>
            <button type="button" id="add-favorite" class="btn btn-info">お気に入り登録</button>
            <button type="button" id="delete-favorite" class="btn btn-info">お気に入り登録解除</button>
        </div> --}}
    @else
        <h5>情報の取得に失敗しました</h5>
    @endif
</div>

<script>
    $(function () {
        $('#add-favorite').on('click', function () {
            // alert("aaa");
            //favoritePost();
        });
    });

    function favoritePost() {
        let _token = $('meta[name="csrf-token"]').attr('content');
        let user_id = {{ Auth::id() }};
        let movie_id = {{ $movie->id }};

        $.ajax({
                type: 'post',
                datatype: 'json',
                url: '/favorite/store',
                data: {
                    '_token': _token,
                    'user_id': user_id,
                    'movie_id': movie_id,
                }
            })
            .done(function (data) {
                if (data['status'] == 200) {

                }
            })
            .fail(function (data) {
                alert('処理に失敗しました。');
            })
    }
</script>
@endsection
