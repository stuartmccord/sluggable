<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Stuartmccord\Sluggable\Slug;

class SluggableTest extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Orchestra\Database\ConsoleServiceProvider',
        ];
    }

    public function setUp()
    {
        parent::setUp();

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);
    }

    /** @test */
    function a_slug_is_added_to_a_sluggable_model_when_it_is_created()
    {
        $model = Slug::create(['title' => 'test']);

        $this->assertEquals('test', $model->slug);
    }

    /** @test */
    function a_unique_slug_is_added_to_the_model_if_the_slug_already_exists()
    {
        $modelA = Slug::create(['title' => 'test']);
        $modelB = Slug::create(['title' => 'test']);

        $this->assertEquals('test', $modelA->slug);
        $this->assertEquals('test-1', $modelB->slug);
    }
}