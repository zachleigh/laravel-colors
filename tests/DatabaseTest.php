<?php

namespace LaravelColors\tests;

use LaravelColors\Colors;

class DatabaseTest extends TestCase
{
    /**
     * @test
     */
    public function it_saves_color_schemes()
    {
        $result = $this->post('laravel-colors/save', ['data' => 'color scheme', 'name' => 'Colors']);

        $saves = $result->response->getOriginalContent();

        $this->assertEquals('Colors', $saves[0]['name']);

        $this->assertEquals('color scheme', $saves[0]['colors']);
    }

    /**
     * @test
     */
    public function it_updates_color_schemes()
    {
        $this->post('laravel-colors/save', ['data' => 'color scheme', 'name' => 'Colors']);

        $result = $this->post('laravel-colors/save', ['data' => 'updated', 'name' => 'Colors']);

        $saves = $result->response->getOriginalContent();

        $this->assertEquals('Colors', $saves[0]['name']);

        $this->assertEquals('updated', $saves[0]['colors']);
    }
}
