<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
use JetBrains\PhpStorm\ArrayShape;

abstract class FileFactoryCommand extends Command
{

    protected Filesystem $file;

    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    abstract function setStubName() : string;

    abstract function setStubPath() : string;

    abstract function setStubSuffix() : string;

    protected function singleClassName($name): string
    {
        return ucwords(Pluralizer::singular($name));
    }

    protected function stubPath(): string
    {
        $setStubName = $this->setStubName();

        return __DIR__ ."/../../../stubs/{$setStubName}.stub";
    }

    protected function makeDir($path)
    {
        $this->file->makeDirectory($path,0777,true,true);
        return $path;
    }

    #[ArrayShape(['Name' => "string"])] protected function stubVariables(): array
    {
        return [
            'Name' =>   $this->singleClassName($this->argument('classname')),
        ];
    }

    protected function stubContent($stubPath,$stubVariables): array|bool|string
    {
        $content = file_get_contents($stubPath);
        foreach ($stubVariables as $search => $name)
        {
            $contents = str_replace('$'.$search,$name,$content);
        }
        return $contents;
    }

    protected function getPath(): string
    {
        $setStubPath = $this->setStubPath();
        $setStubSuffix = $this->setStubSuffix();
        return base_path($setStubPath.'\\').$this->singleClassName($this->argument('classname')).$setStubSuffix.'.php';
    }


    public function handle()
    {
        $path = $this->getPath();

        $this->makeDir(dirname($path));

        if ($this->file->exists($path))
        {
            $this->info('this file already exists');
        }

        $content = $this->stubContent($this->stubPath() ,$this->stubVariables());

        $this->file->put($path, $content);

        $this->info('this file has been created successfully');

    }
}

