<?php

namespace Pratikkuikel\Panini\Models;

use Illuminate\Database\Eloquent\Model;
use Pratikkuikel\Wasabi\Traits\Wasabi;

class PageManager extends Model
{
    use Wasabi;

    protected $guarded = [];

    protected $casts = [
        'fields' => 'array',
        'data' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        if (request()->routeIs('filament.admin.*') || request()->routeIs('livewire.update')) {
            static::setWasabiStatus(false);
        }
        // construct parent after setting data and status
        parent::__construct($attributes);
    }
}
