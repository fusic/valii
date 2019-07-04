<?php
namespace Tests;

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Valii\Providers\ValidatorServiceProvider'
        ];
    }

    protected function getTranslator()
    {
        return new Translator(
            new ArrayLoader, 'en'
        );
    }
}