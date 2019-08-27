<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        if ('testing' !== app()->environment()) {
            echo("The environment is not testing. I quit. This would likely destroy data.\n");
            exit(1);
        }
    }
}
