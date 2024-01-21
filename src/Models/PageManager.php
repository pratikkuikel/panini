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
        'data' => 'array'
    ];
}
