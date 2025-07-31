<?php

declare(strict_types=1);

namespace CommitGlobal\AppVersion\Tests;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;

class AppVersionTest extends TestCase
{
    #[Test]
    public function it_returns_fallback_when_version_file_is_missing(): void
    {
        $this->assertSame(Config::get('app-version.fallback'), app('version'));
    }

    #[Test]
    public function it_returns_version_from_file(): void
    {
        $version = '1.0.0';
        $this->createVersionFile($version);

        $this->assertSame($version, app('version'));
    }

    private function createVersionFile(string $version): void
    {
        file_put_contents(Config::get('app-version.file'), $version);
    }
}
