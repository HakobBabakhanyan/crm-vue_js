<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{

    protected function getDefaultNamespace($rootNamespace)
    {

        return "{$rootNamespace}\Models";
    }
}
