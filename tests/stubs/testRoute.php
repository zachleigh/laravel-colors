<?php

use LaravelColors\Colors;
use Illuminate\Http\Request;
use LaravelColors\ColorScheme;

Route::get('/laravel-colors/colors', function () {
    $colorReader = new Colors();

    $colors = $colorReader->readColorsFile();

    $saves = ColorScheme::all()->toArray();

    return view('laravel-colors::main', compact('colors', 'saves'));
});

Route::post('laravel-colors/save', function (Request $request) {
    $scheme = $request->get('data');

    $name = $request->get('name');

    if ($color = ColorScheme::where('name', $name)->first()) {
        $color->colors = $scheme;

        $color->save();
    } else {
        ColorScheme::create(['name' => $name, 'colors' => $scheme]);
    }

    $saves = ColorScheme::all()->toArray();

    return $saves;
});
