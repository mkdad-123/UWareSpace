<?php

namespace App\Console\Commands;

class CreateServiceClass extends FileFactoryCommand
{

    protected $signature = 'make:service {classname}';


    protected $description = 'This command for create service class pattern';


    function setStubName(): string
    {
        return 'servicepattern';
    }

    function setStubPath(): string
    {
        return 'App\\Services';
    }

    function setStubSuffix(): string
    {
        return 'Service';
    }
}
