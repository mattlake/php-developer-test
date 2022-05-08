<?php

namespace App\Console\Commands;

use App\Actions\UserApiSyncAction;
use Exception;
use Illuminate\Console\Command;

class SyncUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:users
                            {--all : Sync all users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the API users with the DB (first page)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(UserApiSyncAction $action)
    {
        $this->hasOption('all') ?
            $this->info('Syncing all users from the API to the DB')
            : $this->info('Syncing first page of users from the API to the DB');

        try {
            $action->handle($this->option('all'));
        } catch (Exception) {
            $this->error('Could not sync users, please check the logs for more details');
            return 1;
        }

        $this->info('Sync complete');
        return 0;
    }
}
