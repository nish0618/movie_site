<?php
Auth::routes([
    'register' => false,
    'reset'    => false,
    'vertify'  => false
]);

Route::resource('movie', 'MovieController', ['only' => ['index', 'show', 'create', 'store']]);
