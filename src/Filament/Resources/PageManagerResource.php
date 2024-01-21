<?php

namespace Pratikkuikel\Panini\Filament\Resources;

use App\Filament\Admin\Resources\PageManagerResource\Pages\Demo;
use Closure;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
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
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Builder\Block;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Log;
use Pratikkuikel\Panini\Filament\Fields\PaniniTextInput;
use Pratikkuikel\Panini\Filament\Resources\PageManagerResource\Pages;
use Pratikkuikel\Panini\Models\PageManager;
use Pratikkuikel\Panini\Filament\Fields\PaniniField;
use Pratikkuikel\Panini\Filament\Pages\ResourceGenerator;

class PageManagerResource extends Resource
{
    protected static ?string $model = PageManager::class;

    protected static ?string $modelLabel = 'Page Manager';

    protected static ?string $pluralModelLabel = 'Page Manager';

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'Panini';

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ResourceGenerator::class
        ]);
    }

    // generate page from stub, don't use filament page generation command.
    // And that page should have a form that is generated from page manager's fields
    // Remove wasabi from filament routes with a condition

    public static $fieldsets = [
        [
            'type' => PaniniTextInput::class,
            'name' => 'hello',
            'label' => 'helloLabel',
            'attributes' => [
                ['name' => 'email', 'value' => true],
                ['name' => 'required', 'value' => true],
            ],
        ],
        [
            'type' => PaniniTextInput::class,
            'name' => 'hey',
            'label' => 'heyLabel',
            'attributes' => [
                ['name' => 'email', 'value' => true],
                ['name' => 'required', 'value' => true],
            ],
        ],
    ];

    public static function form(Form $form): Form
    {
        // PaniniField::getAttributes('Pratikkuikel\Panini\Filament\Fields\PaniniTextInput');
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Section::make('Fields')
                    ->schema([
                        Repeater::make('fields')
                            ->schema([
                                Select::make('type')
                                    ->options(PaniniField::all())
                                    ->searchable()
                                    ->required(),
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('label'),
                                KeyValue::make('attributes')
                                    ->addable(true),
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('Add field to the page'),
                    ])
                    ->collapsible(true),
                Section::make('Here goes the content of your page !')
                    ->schema([
                        Repeater::make('data')
                            ->schema(static::FieldGenerator(static::$fieldsets)),
                    ]),
                // ->visibleOn('edit')
            ]);
    }

    public static function FieldTypesWithAttributes()
    {
        $types = [
            [
                'type' => PaniniTextInput::class,
                'attributes' => [
                    'email', 'numeric', 'password', 'tel', 'url',
                ],
            ],
            [
                'type' => Select::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => FileUpload::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => Checkbox::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => Toggle::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => CheckboxList::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => Radio::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => DateTimePicker::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => FileUpload::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => RichEditor::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => MarkdownEditor::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => Textarea::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => KeyValue::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
            ],
            [
                'type' => ColorPicker::class,
                'attributes' => [
                    'options', 'native', 'searchable', 'multiple',
                ],
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
