<?php

namespace Pratikkuikel\Panini\Filament\Fields;

use Filament\Forms\Components\TextInput;

class PaniniTextInput
{
    public static function make(string $name, array $attributes): TextInput
    {
        $textInput = TextInput::make($name);

        $outputArray = [];

        foreach ($attributes as $item) {
            if (isset($item['name'])) {
                $outputArray[$item['name']] = $item['value'] ?? null;
            }
        }

        foreach ($outputArray as $key => $value) {
            $textInput->$key($value);
        }

        return $textInput;
    }

    public static function attributes()
    {
        return collect([
            'email' => 'email',
            'required' => 'required',
        ]);
    }
}
