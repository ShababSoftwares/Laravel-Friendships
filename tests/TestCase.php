<?php

namespace Tests;

require __DIR__.'/helpers.php';

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
