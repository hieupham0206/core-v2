<?php

namespace Cloudteam\CoreV2\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeEnumCommand extends GeneratorCommand
{
    protected $signature = 'make:enum
						{name : Tên file enum}
						{--option= : Option của enum (VD: COMPANY,1;BRANCH,2)}
						{--force=}';

    protected $description = 'Tạo file enum';

    protected $type = 'Enum';

    protected function buildClass($name)
    {
        $option           = $this->option('option');//COMPANY,1;BRANCH,2
        $constOption      = '';
        $constDescription = 'return match ($this) {'."\n";

        $returnType = 'string';

        if ($option) {
            $options = explode(';', $option);

            foreach ($options as $option) {
                [$option, $value] = explode(',', $option);

                if (is_numeric($value)) {
                    $returnType = 'int';
                }

                $optionDesc = strtolower($option);

                $constOption      .= "case $option = $value;"."\n\t";
                $constDescription .= "\t\t\tself::$option => __('$optionDesc'),"."\n";
            }
        }

        $constDescription .= "\t\t};";

        $stub = $this->files->get($this->getStub());

        return $this->replaceConstDescription($stub, $constDescription)
                    ->replaceConstOption($stub, $constOption)
                    ->replaceReturnType($stub, $returnType)
                    ->replaceClass($stub, $name);
    }

    protected function getStub()
    {
        return __DIR__.'/../stubs/enum.stub';
    }

    protected function replaceNamespace(&$stub, $name)
    {
        return $this;
    }

    protected function replaceReturnType(&$stub, $desc): self
    {
        $stub = str_replace('{$returnType}', $desc, $stub);

        return $this;
    }

    protected function replaceConstOption(&$stub, $desc): self
    {
        $stub = str_replace('{$constOption}', $desc, $stub);

        return $this;
    }

    protected function replaceConstDescription(&$stub, $desc): self
    {
        $stub = str_replace('{$constDescription}', $desc, $stub);

        return $this;
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
        return $rootNamespace.'\Enums';
    }
}
