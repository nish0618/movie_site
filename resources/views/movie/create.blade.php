@extends('layouts.app')
@section('content')

<a href='{{ route('movie.index') }}'><button class="btn btn-outline-info">一覧に戻る</button></a>

    <div class="container mt-5">
        <div class="header">
            <h1>投稿ページ</h1>
        </div>
        @if (session('flash_message'))
        <div class="flash_message">
            {{ session('flash_message') }}
        </div>
        @endif
        <div class="content_wrapper">
            <div class="content2">
                <form action="{{ route('movie.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="user_agent" value="{{ $_SERVER['HTTP_USER_AGENT'] }}">
                        <input type="hidden" name="ip_adress" value="{{ $_SERVER['REMOTE_ADDR'] }}">
                    タイトル：<input type="test" name="movie_title" value="{{ old('movie_title') }}" placeholder="タイトルです。"><br>
                    @error('movie_title')
                        <p class="error">{{ $message }}</p>
                    @enderror
                        説明：<br>
                        <textarea name="movie_description" rows="4" cols="40" placeholder="説明です。" value="{{ old('movie_description') }}"></textarea><br>
                    @error('movie_description')
                        <p class="error">{{ $message }}</p>
                    @enderror

                        <input type="file" name="post_movie"><br>
                    @error('post_movie')
                        <p class="error">{{ $message }}</p>
                    @enderror

                    <input type="reset" class="btn btn-secondary" value="リセット">

                    <button id="js-modal-open" class="btn btn-primary">アップロードする</button>

                    <!-- ▼modal -->
                    <div class="modal js-modal">
                        <div class="modal__bg"></div>
                        <div class="modal__content">
                            <p>動画をアップロードしてもよろしいですか？</p>
                            <div>
                                <button class="js-modal-close back-btn btn btn-secondary">戻る</button>
                                <button class="loading-back btn btn-dark" disabled>戻る</button>
                                <button type="submit" class="btn btn-primary">アップロードする</button>
                                <button class="loading btn btn-dark" disabled>アップロード中</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $("#js-modal-open").on("click", function () {
            $('.js-modal').fadeIn();
            return false;
        });

        $('.js-modal-close').on('click', function () {
            $('.js-modal').fadeOut();
            return false;
        });

        $('button[type="submit"]').on('click', function () {
            $(this).hide();
            $('.back-btn').hide();
            $('.loading').show();
            $('.loading-back').show();
        });
    </script>

@endsection
