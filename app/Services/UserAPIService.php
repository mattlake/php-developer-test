<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\ApiUserData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserAPIService implements \App\Contracts\UserAPIService
{
    const USERS_ENDPOINT = 'https://reqres.in/api/users';

    public function fetchUsers(bool $allUsers = false): Collection
    {
        $page = 1;

        $users = collect();

        do {
            $response = Http::get($this->getBaseUrl($page, $allUsers))->throw()->collect();

            $users = $users->merge(
                $response->get('data')
            );

            // If we only want the first page then we will escape the loop.
            if ($allUsers == false) {
                break;
            }

            $page++;
        } while ($page <= $response->get('total_pages'));

        return $this->createDTOs($users);
    }

    /**
     * We increase the number of users returned per page request to reduce the number of api calls
     * This makes little difference for the 12 users that the api currently provides but if
     * there were hundreds/thousands it would be a lot of wasted I/O and time.
     */
    public function getBaseUrl(int $page = 1, bool $allUsers = false): string
    {
        return $allUsers ?
            self::USERS_ENDPOINT . "?page={$page}&per_page=100"
            : self::USERS_ENDPOINT . "?page={$page}";
    }

    public function createDTOs(Collection $response): Collection
    {
        return $response->collect('data')
            ->map(
                fn (array $user) => new ApiUserData(
                    $user['id'],
                    $user['email'],
                    $user['first_name'],
                    $user['last_name'],
                    $user['avatar'],
                    Hash::make('password-generator-here'),
                )
            );
    }
}