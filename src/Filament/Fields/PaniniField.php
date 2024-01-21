<?php

namespace Pratikkuikel\Panini\Filament\Fields;

class PaniniField
{
    public static function all()
    {
        $files = glob(__DIR__ . '/*.php');
        $fields = [];

        foreach ($files as $filename) {
            if (basename($filename) === 'PaniniField.php') {
                continue;
            }
            // determine class name from file name
            // This method is inspired from spatie's Holidays
            $fieldClass = 'Pratikkuikel\\Panini\\Filament\\Fields\\' . basename($filename, '.php');

            $fields[$fieldClass] = $fieldClass;
        }
        return $fields;
        // dd($fields);
    }

    public static function getAttributes(string $field)
    {
        // $fields = static::all();
        // dd($fields);
        $field = new $field;
        return $field::attributes();
    }
}
