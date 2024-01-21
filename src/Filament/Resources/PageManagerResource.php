<?php

namespace Pratikkuikel\Panini\Filament\Resources;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Pratikkuikel\Panini\Filament\Resources\PageManagerResource\Pages;
use Pratikkuikel\Panini\Models\PageManager;
use Pratikkuikel\Panini\Filament\Fields\PaniniTextInput;

class PageManagerResource extends Resource
{
    protected static ?string $model = PageManager::class;

    protected static ?string $modelLabel = 'Page Manager';

    protected static ?string $pluralModelLabel = 'Page Manager';

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'Panini';

    public static $fieldsets = [
        [
            'type' => PaniniTextInput::class,
            'name' => 'hello',
            'label' => 'helloLabel',
            'attributes' => [
                ['name' => 'email', 'value' => true],
                ['name' => 'required', 'value' => true],
            ]
        ],
        [
            'type' => PaniniTextInput::class,
            'name' => 'hey',
            'label' => 'heyLabel',
            'attributes' => [
                ['name' => 'email', 'value' => true],
                ['name' => 'required', 'value' => true],
            ]
        ],
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Section::make('Fields')
                    ->schema([
                        Repeater::make('fields')
                            ->schema([
                                Select::make('type')
                                    ->options(static::FieldTypesWithAttributes()->pluck('type'))
                                    ->searchable()
                                    ->required(),
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('label'),
                                Select::make('attributes')
                                    ->multiple()
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('Add field to the page')
                    ]),
                Section::make('Here goes the content of your page !')
                    ->schema([
                        Repeater::make('data')
                            ->schema(static::FieldGenerator(static::$fieldsets))
                    ])
                // ->visibleOn('edit')
            ]);
    }

    public static function FieldTypesWithAttributes()
    {
        $types = [
            [
                'type' => PaniniTextInput::class,
                'attributes' => [
                    'email', 'numeric', 'password', 'tel', 'url'
                ]
            ],
            [
                'type' => Select::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => FileUpload::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => Checkbox::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => Toggle::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => CheckboxList::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => Radio::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => DateTimePicker::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => FileUpload::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => RichEditor::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => MarkdownEditor::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => Textarea::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => KeyValue::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
            [
                'type' => ColorPicker::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple'
                ]
            ],
        ];
        return collect($types);
    }

    public static function FieldGenerator(array $fieldsets)
    {
        $fields = [];
        foreach ($fieldsets as $field) {
            $fields[] = $field['type']::make($field['name'], $field['attributes']);
        }
        return $fields;
        // dd($fields);
        // return [
        //     PaniniTextInput::make('hello'),
        // ];
        // dd($fields);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageManagers::route('/'),
            'create' => Pages\CreatePageManager::route('/create'),
            'edit' => Pages\EditPageManager::route('/{record}/edit'),
        ];
    }
}
