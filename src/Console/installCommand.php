<?php

namespace Esign\InlineEdit\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class InstallCommand extends Command
{
    protected $signature = 'inline-editing:install';

    public function handle()
    {
        $this->copyStubs();

        $this->comment('Please execute the "npm install && npm run watch" command to build your assets.');
    }

    protected function copyStubs(): void
    {
        (new FileSystem())->ensureDirectoryExists(resource_path('assets/js/utils'));
        (new Filesystem())->copy(
            __DIR__ . '/../../stubs/inlineEdit.js',
            resource_path('assets/js/utils/inlineEdit.js')
        );
    }
}