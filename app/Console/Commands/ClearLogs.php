<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLogs extends Command
{
    protected $signature = 'logs:clear';
    protected $description = 'Clear the log file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        file_put_contents(storage_path('logs/laravel.log'), '');
        $this->info('Log file cleared!');
    }
}
