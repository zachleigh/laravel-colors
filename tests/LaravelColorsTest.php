<?php

namespace LaravelColors\tests;

use LaravelColors\Colors;

class LaravelColorsTest extends TestCase
{
    /**
     * @before
     */
    public function before()
    {
        $this->colorReader = new Colors();

        $this->results = $this->colorReader->readColorsFile();
    }

    /**
     * @test
     */
    public function it_gets_the_color_variable_name()
    {
        $this->assertEquals('red', $this->results[0]['name']);
        $this->assertEquals('orange', $this->results[1]['name']);
        $this->assertEquals('yellow', $this->results[2]['name']);
        $this->assertEquals('green', $this->results[3]['name']);
        $this->assertEquals('blue', $this->results[4]['name']);
        $this->assertEquals('purple', $this->results[5]['name']);
    }

    /**
     * @test
     */
    public function it_gets_the_color_values()
    {
        $this->assertEquals('rgb(244,67,54)', $this->results[0]['rgb']);
        $this->assertEquals('#ff9800', $this->results[1]['hex']);
        $this->assertEquals('rgb(76,175,80)', $this->results[3]['rgb']);
        $this->assertEquals('#2196f3', $this->results[4]['hex']);
    }

    /**
     * @test
     */
    public function it_converts_hex_to_rgb()
    {
        $this->assertEquals('rgb(244,67,54)', $this->results[0]['rgb']);
        $this->assertEquals('rgb(255,152,0)', $this->results[1]['rgb']);
        $this->assertEquals('rgb(255,235,59)', $this->results[2]['rgb']);
    }

    /**
     * @test
     */
    public function it_converts_three_digit_hex_to_rgb()
    {
        $this->assertEquals('rgb(255,255,255)', $this->results[6]['rgb']);
    }

    /**
     * @test
     */
    public function it_converts_rgb_to_hex()
    {
        $this->assertEquals('#4caf50', $this->results[3]['hex']);
        $this->assertEquals('#2196f3', $this->results[4]['hex']);
        $this->assertEquals('#673ab7', $this->results[5]['hex']);
    }

    /**
     * @test
     */
    public function it_passes_comments()
    {
        $this->assertFalse(array_key_exists('black', $this->results));
        $this->assertFalse(array_key_exists('pink', $this->results));
    }

    /**
     * @test
     */
    public function it_passes_non_color_variables()
    {
        $this->assertFalse(array_key_exists('width', $this->results));
    }

    /**
     * @test
     */
    public function it_passes_non_variables()
    {
        $this->assertCount(7, $this->results);
    }

    /**
     * @test
     */
    public function it_gets_default_colors_if_route_is_none()
    {
        $this->app['config']->set('laravel-colors.sass_file', 'none');

        $this->visit('/laravel-colors/colors')
             ->seeStatusCode(200)
             ->see('red')
             ->see('orange')
             ->see('yellow')
             ->see('green')
             ->see('blue')
             ->see('purple');

        $this->app['config']->set('laravel-colors.sass_file', '/'.implode('/', explode('/', ltrim(__DIR__, '/'))).'/colors.scss');
    }

    /**
     * @test
     */
    public function it_routes_correctly()
    {
        $this->visit('/laravel-colors/colors')
             ->seeStatusCode(200);
    }

    /**
     * @test
     */
    public function view_shows_color_name()
    {
        $this->visit('/laravel-colors/colors')
             ->see('red');
    }

    /**
     * @test
     */
    public function view_shows_hex_color_value()
    {
        $this->visit('/laravel-colors/colors')
             ->see('#ffeb3b');
    }

    /**
     * @test
     */
    public function view_shows_rgb_color_value()
    {
        $this->visit('/laravel-colors/colors')
             ->see('rgb(76,175,80)');
    }
}
