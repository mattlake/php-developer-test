<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\ApiUserData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserAPIService
{
    const USERS_ENDPOINT = 'https://reqres.in/api/users';

    public function fetchUsers(): array
    {
        $response = Http::get(self::USERS_ENDPOINT);

        $response->throw();

        return array_map(function (array $user) {
            return new ApiUserData(
                $user['id'],
                $user['email'],
                $user['first_name'],
                $user['last_name'],
                $user['avatar'],
                Hash::make('password-generator-here'),
            );
        }, json_decode($response->body(), true)['data']);
    }
}