<?php

namespace Cloudteam\CoreV2\Console\Commands;

use Illuminate\Console\Command;

class MakeMultipleMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:migrations {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create multiple migration file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        if (strpos($table, ',') !== false) {
            $tables = explode(',', $table);
        } else {
            $tables = [$table];
        }

        foreach ($tables as $table) {
            $this->call('make:migration', [
                'name' => "create_{$table}_table",
            ]);
        }
    }
}
