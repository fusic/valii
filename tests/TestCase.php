<?php
namespace Tests;

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'Valii\Providers\ValidatorServiceProvider'
        ];
    }
}