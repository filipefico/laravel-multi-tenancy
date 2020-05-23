<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand as MigrateCommand;

class MigrateMakeCommand extends MigrateCommand
{
    /**
     * Get migration path (either specified by '--path' option or default location).
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        if (! is_null($targetPath = $this->input->getOption('path'))) {
            return ! $this->usingRealPath()
                ? $this->laravel->basePath().'/'.$targetPath
                : $targetPath;
        }

        return $this->laravel->databasePath().DIRECTORY_SEPARATOR.'migrations/system';
    }
}
