<?php

declare(strict_types=1);

namespace App\Actions;

use App\DataTransferObjects\ApiUserData;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserApiSyncAction
{
    public function handle()
    {
        // Fetch Users
        $response = Http::get('https://reqres.in/api/users');

        if ($response->failed()) {
            throw new Exception('Could not contact API');
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
        User::upsert(
            array_map(fn ($user) => $user->toArray(), $users),
            'id',
            ['id', 'email', 'first_name', 'last_name', 'avatar']
        );
    }
}