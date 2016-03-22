<?php

use LaravelColors\Colors;
use Illuminate\Http\Request;
use LaravelColors\LaravelColor;

Route::get(config('laravel-colors.route'), function () {
    $colorReader = new Colors();

    $colors = $colorReader->readColorsFile();

    $saves = LaravelColor::all()->toArray();

    return view('laravel-colors::main', compact('colors', 'saves'));
});

Route::post('laravel-colors/save', function (Request $request) {
    $scheme = $request->get('data');

    $name = $request->get('name');

    if ($color = LaravelColor::where('name', $name)->first()) {
        $color->colors = $scheme;

        $color->save();
    } else {
        LaravelColor::create(['name' => $name, 'colors' => $scheme]);
    }

    $saves = LaravelColor::all()->toArray();

    return $saves;
});
