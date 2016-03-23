<?php

namespace LaravelColors\Http\Controllers;

use LaravelColors\Colors;
use Illuminate\Http\Request;
use LaravelColors\ColorScheme;
use Illuminate\Routing\Controller as BaseController;

class LaravelColorsController extends BaseController
{
    /**
     * Return main page.
     *
     * @return view
     */
    public function index()
    {
        $colorReader = new Colors();

        $colors = $colorReader->readColorsFile();

        $saves = ColorScheme::all()->toArray();

        return view('laravel-colors::main', compact('colors', 'saves'));
    }

    /**
     * Create a new color scheme.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function create(Request $request)
    {
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
    }

    /**
     * Update a color scheme name.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function update(Request $request)
    {
        $name = $request->get('name');

        $newName = $request->get('newName');

        $scheme = ColorScheme::where('name', $name)->first();

        $scheme->name = $newName;

        $scheme->save();

        $saves = ColorScheme::all()->toArray();

        return $saves;
    }

    /**
     * Delete a color scheme.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function delete(Request $request)
    {
        $name = $request->get('name');

        $scheme = ColorScheme::where('name', $name)->first();

        $scheme->delete();

        $saves = ColorScheme::all()->toArray();

        return $saves;
    }
}
