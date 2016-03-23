<?php

namespace LaravelColors\tests;

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

    /**
     * @test
     */
    public function it_renames_color_scheme()
    {
        $this->post('laravel-colors/save', ['data' => 'color scheme', 'name' => 'Colors']);

        $result = $this->post('laravel-colors/update', ['name' => 'Colors', 'newName' => 'New Name']);

        $saves = $result->response->getOriginalContent();

        $this->assertEquals('New Name', $saves[0]['name']);
    }

    /**
     * @test
     */
    public function it_deletes_color_scheme()
    {
        $this->post('laravel-colors/save', ['data' => 'color scheme', 'name' => 'Colors']);

        $result = $this->post('laravel-colors/delete', ['name' => 'Colors']);

        $saves = $result->response->getOriginalContent();

        $this->assertEmpty($saves);
    }
}
