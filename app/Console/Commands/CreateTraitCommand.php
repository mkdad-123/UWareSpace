<?php

namespace App\Console\Commands;

class CreateTraitCommand extends FileFactoryCommand
{

    protected $signature = 'make:trait {classname}';


    protected $description = 'This command for create trait ';


    function setStubName(): string
    {
        return 'trait';
    }

    function setStubPath(): string
    {
        return 'App\\Traits';
    }

    function setStubSuffix(): string
    {
        return 'Trait';
    }
}
