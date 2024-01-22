<?php

namespace Pratikkuikel\Panini\Generators;

use Touhidurabir\StubGenerator\Facades\StubGenerator;
use Illuminate\Support\Str;

class PageGenerator
{
    public static function generate($name, $fieldsets)
    {
        $fields = static::fieldGenerator($fieldsets);

        $properties = static::propertyGenerator($fieldsets);

        $className = static::transformToClassName($name);

        $viewName = static::transformToViewName($className);

        static::generatePage($className, $viewName, $fields, $properties);

        static::generateView($viewName);

        return $viewName;
    }

    public static function generatePage($className, $viewName, $fields, $properties)
    {
        $stubFilePath = static::getStubPath() . '/page.stub';
        $filamentPagePath = app_path() . '\Filament\Admin\Pages';
        StubGenerator::from($stubFilePath, true)
            ->to($filamentPagePath, createIfNotExist: true, asFullPath: true)
            ->as($className)
            ->ext('php')
            ->replace(true)
            ->withReplacers([
                'class' => $className,
                'view' => $viewName,
                'fields' => $fields,
                'properties' => $properties,
            ])
            ->save();
    }

    public static function propertyGenerator(array $fieldsets)
    {
        $properties = "";

        foreach ($fieldsets as $field) {
            $properties = $properties . "public $" . $field['name'] . ";\n";
        }

        return $properties;
    }

    public static function fieldGenerator(array $fieldsets)
    {

        $fields = "";

        foreach ($fieldsets as $field) {
            $fields = $fields . $field['type']::make($field['name'], $field['attributes']);
        }

        return $fields;
    }

    public static function generateView($viewName)
    {
        $stubFilePath = static::getStubPath() . '/view.stub';

        $filamentViewPath = resource_path() . '\views\filament\admin\pages';

        StubGenerator::from($stubFilePath, true)
            ->to($filamentViewPath, createIfNotExist: true, asFullPath: true)
            ->as($viewName)
            ->ext('blade.php')
            ->replace(true)
            ->withReplacers([])
            ->save();
    }

    public static function getStubPath()
    {
        $currentDir = __DIR__;

        return realpath($currentDir . '../../Stubs');
    }

    public static function transformToClassName($name)
    {
        // Remove dashes and replace spaces with dashes
        $formatted = str_replace(' ', '-', $name);

        // Convert to camel case with the first character in uppercase
        $className = Str::studly($formatted);

        return $className;
    }

    public static function transformToViewName($className)
    {
        // Convert to kebab case
        $viewName = Str::kebab($className);

        return $viewName;
    }
}
