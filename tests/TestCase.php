<?php
namespace Tests;

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getTranslator()
    {
        return new Translator(
            new ArrayLoader, 'en'
        );
    }
}