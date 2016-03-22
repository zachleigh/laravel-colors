<?php

namespace LaravelColors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LaravelColor extends Model
{
    /**
     * Tabel for model.
     *
     * @var string
     */
    protected $table = 'laravel_colors';

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
