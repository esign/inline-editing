<?php

namespace Esign\InlineEdit\Tests;
use Esign\InlineEdit\InlineEditServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [InlineEditServiceProvider::class];
    }
}
