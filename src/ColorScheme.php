<?php

namespace LaravelColors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ColorScheme extends Model
{
    /**
     * Tabel for model.
     *
     * @var string
     */
    protected $table = 'color_schemes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'colors'
    ];
}
