<?php

namespace Pratikkuikel\Panini\Commands;

use Illuminate\Console\Command;

class PaniniCommand extends Command
{
    public $signature = 'panini';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
