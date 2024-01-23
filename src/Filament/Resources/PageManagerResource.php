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
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Pratikkuikel\Panini\Filament\Fields\PaniniTextInput;
use Pratikkuikel\Panini\Filament\Pages\ResourceGenerator;
use Pratikkuikel\Panini\Filament\Resources\PageManagerResource\Pages;
use Pratikkuikel\Panini\Models\PageManager;
use Pratikkuikel\Panini\Filament\Fields\PaniniField;
use Filament\Tables\Actions\Action;
use Pratikkuikel\Panini\Generators\PageGenerator;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Str;

class PageManagerResource extends Resource
{
    protected static ?string $model = PageManager::class;

    protected static ?string $modelLabel = 'Page Manager';

    protected static ?string $pluralModelLabel = 'Page Manager';

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'Panini';

    // public static function getRecordSubNavigation(Page $page): array
    // {
    //     return $page->generateNavigationItems([
    //         ResourceGenerator::class
    //     ]);
    // }

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
                    ->unique(ignoreRecord: true)
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
                                KeyValue::make('attributes')
                                    ->addable(true),
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('Add field to the page'),
                    ])
                    ->collapsible(true),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Page Name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalDescription('Deleting this would make your page orphan with no data source, Add model to the page to keep it functioning after this has been deleted.'),
                Action::make('Download')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->tooltip('Download Fields')
                    ->action(function (PageManager $record) {
                        $headers = [
                            'Content-Type' => 'application/json',
                            'Content-Disposition' => 'attachment; filename="' . $record->name . '.json"'
                        ];
                        $jsonString = json_encode($record->fields);
                        $response = response()
                            ->stream(function () use ($jsonString) {
                                echo $jsonString;
                            }, 200, $headers);
                        return $response;
                    }),
                Tables\Actions\ReplicateAction::make()
                    ->excludeAttributes(['data'])
                    ->form([
                        TextInput::make('name')->unique()->required(),
                    ])
                    ->beforeReplicaSaved(function (PageManager $replica, array $data): void {
                        $data['name'] = Str::kebab($data['name']);
                        $replica->fill($data);
                    }),
                Action::make('Generate')
                    ->icon('heroicon-m-bolt')
                    ->tooltip('Generate Page')
                    ->requiresConfirmation(true)
                    ->modalHeading('Generate Page')
                    ->modalDescription('Are you sure you\'d like to generate this page? This will replace existing Page with same name 💀')
                    ->modalSubmitActionLabel('Yes, Please')
                    ->action(function (PageManager $record) {
                        $response = PageGenerator::generate($record->name, $record->fields);
                        Notification::make()
                            ->title('Page Generated Successfully !')
                            ->actions([
                                NotificationAction::make('visit')
                                    ->button()
                                    ->url(url(
                                        'admin/' . $response
                                    ), shouldOpenInNewTab: false)
                            ])
                            ->body('These fields were generated \n' . json_encode($record->fields))
                            ->success()
                            ->send();
                    }),
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
