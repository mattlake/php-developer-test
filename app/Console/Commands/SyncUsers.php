<?php

namespace App\Console\Commands;

use App\DataTransferObjects\ApiUserData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

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
    public function handle()
    {
        // Fetch Users
        $response = Http::get('https://reqres.in/api/users');

        if ($response->failed()) {
            throw new \Exception('Could not contact API');
        }

        $users = array_map(function (array $user) {
            return new ApiUserData(
                $user['id'],
                $user['email'],
                $user['first_name'],
                $user['last_name'],
                $user['avatar'],
                Hash::make('password-generator-here'),
            );
        }, json_decode($response->body(), true)['data']);

        /**
         * Using an upsert like this will only sotre the password on insertions as
         * we don't want to update any existing passwords
         */
        \App\Models\User::upsert(
            array_map(fn ($user) => $user->toArray(), $users),
            'id',
            ['id', 'email', 'first_name', 'last_name', 'avatar']
        );

        return 0;
    }
}
