<?php

declare(strict_types=1);

namespace CommitGlobal\AppVersion\Tests;

use CommitGlobal\AppVersion\AppVersionServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            AppVersionServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        File::delete(Config::get('app-version.file'));
    }
}
