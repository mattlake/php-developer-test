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
    protected $signature = 'sync:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the API users with the DB';

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
        $this->info('Syncing APi users with DB');

        try {
            $action->handle();
        } catch (Exception) {
            $this->error('Could not sync users, please check the logs for more details');
            return 1;
        }

        $this->info('Sync complete');
        return 0;
    }
}
