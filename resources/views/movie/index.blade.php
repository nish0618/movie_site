@extends('layouts.app')
@section('content')
<a href='{{ route('movie.create') }}'><button class="btn btn-outline-info">動画を投稿する</button></a>
<div class="container mt-5">
    <div class="header">
        <h1>動画一覧</h1>
    </div>
    <div>
        全{{ $movies->total() }}件
    </div>
    @if ($movies->isNotEmpty())
        <ul class="movie-list">
        @foreach ($movies as $movie)
            <li class="movie-item">
                <p>{{ $movie->movie_title }}</p>
                <a href="{{ route('movie.show', $movie->id) }}">
                    <video src='{{ $movie->movie_path }}' width="200px" height="100px"></video>
                </a>
                <p>{{ $movie->user->name }}</p>
            </li>
        @endforeach
        </ul>
    @endif

    @if ($movies->isNotEmpty())
    {{ $movies->appends(request()->input())->links() }}
    @endif
</div>
@endsection
