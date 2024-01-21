<?php

namespace Pratikkuikel\Panini\Filament\Pages;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class ResourceGenerator extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    protected static ?string $navigationGroup = 'Panini';

    protected static ?string $title = 'Resource Generator';

    protected ?string $heading = 'Resource Generator 🎉';

    protected ?string $page_description = 'With gui based resource generator 😀';

    protected static string $view = 'panini::filament.resource-generator';

    public ?array $data = [];

    public $model_name;

    public $generate_filament = true;

    // public $is_page = false;

    public $soft_deletes = false;

    public $generate_view = false;

    public $is_simple_resource = false;

    public $generate_factory = true;

    public $generate_controller = true;

    public $generate_migration = true;

    public $generate_seeder = true;

    public static function shouldRegisterNavigation(): bool
    {
        return app()->environment('local');
        // return app()->environment('production');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        TextInput::make('model_name')
                            ->label('Name of the model')
                            ->required(),
                        Section::make('Controller Factory Migration Seeder')
                            ->schema([
                                Toggle::make('generate_controller')
                                    ->label('Generate a controller'),
                                Toggle::make('generate_factory')
                                    ->label('Generate a factory'),
                                Toggle::make('generate_migration')
                                    ->label('Generate a migration'),
                                Toggle::make('generate_seeder')
                                    ->label('Generate a seeder'),
                            ])->columns(2),
                        Toggle::make('generate_filament')
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                if ($state) {
                                    $set('is_page', false);
                                    $set('is_simple_resource', false);
                                    $set('soft_deletes', false);
                                    $set('generate_view', false);
                                }
                            })
                            ->label('Generate Filament resource or page'),
                        Section::make('Filament')
                            ->schema([
                                // Checkbox::make('is_page')
                                //     ->live()
                                //     ->disabled(fn ($get) => $get('generate_filament') ? false : true)
                                //     ->afterStateUpdated(function ($state, $set, $get) {
                                //         if ($state) {
                                //             $set('is_simple_resource', false);
                                //             $set('soft_deletes', false);
                                //             $set('generate_view', false);
                                //         }
                                //     })
                                //     ->label('This is a page not a resource, I need a page !'),
                                Checkbox::make('is_simple_resource')
                                    ->label('I need a simple resource !')
                                    ->disabled(fn ($get) => $get('generate_filament') ? false : true)
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        if ($state) {
                                            return $set('is_page', false);
                                        }
                                    }),
                                Checkbox::make('soft_deletes')
                                    ->disabled(fn ($get) => $get('is_page') || !$get('generate_filament') ? true : false)
                                    ->live()
                                    ->label('Enable soft deletes'),
                                Checkbox::make('generate_view')
                                    ->disabled(fn ($get) => $get('is_page')  || !$get('generate_filament') ? true : false)
                                    ->live()
                                    ->label('Generate view too !'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public function magic()
    {
        $data = $this->form->getState();
        $output1 = $this->generateMMCFS($data);
        Notification::make()
            ->title('Resources have been generated !')
            ->body($output1)
            ->success()
            ->send();
        if ($data['generate_filament']) {
            $output2 = $this->generateResource($data);
            Notification::make()
                ->title('Resources have been generated !')
                ->body($output2)
                ->success()
                ->send();
        }
    }

    protected function generateMMCFS($data)
    {
        $options = [
            '--migration' => $data['generate_migration'],       // Generate a migration file
            '--controller' => $data['generate_controller'],    // Generate a controller
            '--factory' => $data['generate_factory'],         // Generate a factory
            '--seed' => $data['generate_seeder'],            // Generate a seeder
        ];

        Artisan::call('make:model', [
            'name' => Str::ucfirst($data['model_name']),
        ] + $options);

        $output = Artisan::output();
        return $output;
    }

    protected function generateResource($data)
    {
        $options = [
            '--simple' => $data['is_simple_resource'],   // Generate a simple resource
            '--soft-deletes' => $data['soft_deletes'],  // Generate a resource with soft deletes
            '--view' => $data['generate_view'],        // Generate a resource with a custom view
        ];

        Artisan::call('make:filament-resource', [
            'name' => $data['model_name'],
        ] + $options);

        $output = Artisan::output();
        return $output;
    }
}
