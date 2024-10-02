<?php

namespace Cloudteam\CoreV2\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class CrudServiceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:service
                            {name : The name of the service.}
                            {--crud= : Tên của table trong database.}
                            {--model= : The name of the Model.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model service class';

    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/service.stub';
    }

    public function buildClass($name)
    {
        $stub            = $this->files->get($this->getStub());
        $this->crudName  = $this->option('crud');
        $this->modelName = $this->option('model');

        return $this
            ->replaceCrudNameSingular($stub, Str::singular(Str::studly($this->crudName)))
            ->replaceModelName($stub, $this->modelName)
            ->replaceClass($stub, $name);
    }

    /**
     * Replace the crudNameSingular for the given stub.
     *
     * @param string $stub
     * @param string $crudNameSingular
     *
     * @return $this
     */
    protected function replaceCrudNameSingular(&$stub, $crudNameSingular): self
    {
        $stub = str_replace('{{crudNameSingular}}', lcfirst($crudNameSingular), $stub);

        return $this;
    }

    /**
     * Replace the modelName for the given stub.
     *
     * @param string $stub
     * @param string $modelName
     *
     * @return $this
     */
    protected function replaceModelName(&$stub, $modelName): self
    {
        $stub = str_replace('{{modelName}}', $modelName, $stub);

        return $this;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name').'Service');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Services';
    }
}
