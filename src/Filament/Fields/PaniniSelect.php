<?php

namespace Pratikkuikel\Panini\Filament\Fields;

class PaniniSelect
{
    // public static function make(string $name, array $attributes)
    // {
    //     $textInput = Select::make($name);

    //     $outputArray = [];

    //     foreach ($attributes as $item) {
    //         if (isset($item['name'])) {
    //             $outputArray[$item['name']] = $item['value'] ?? null;
    //         }
    //     }

    //     foreach ($outputArray as $key => $value) {
    //         $textInput->$key($value);
    //     }

    //     return $textInput;
    // }

    public static function make(string $name, array $attributes)
    {
        $representation = "\Filament\Forms\Components\Select::make('$name')";

        $counter = 0;
        $count = count($attributes);

        foreach ($attributes as $key => $value) {
            if ($counter == $count - 1) {
                $representation = $representation . "\n->$key($value),\n";
            } else {
                $representation = $representation . "\n->$key($value)";
            }
            $counter++;
        }

        return $representation;
    }
}
