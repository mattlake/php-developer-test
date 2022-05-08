<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use App\Services\UserAPIService;

class UserApiSyncAction
{
    private \App\Contracts\UserAPIService $userService;

    public function __construct()
    {
        // There are better ways to resolve/inject this from the container, if the time allowed.
        $this->userService = resolve(UserAPIService::class);
    }

    public function handle(bool $allUsers = false)
    {
        // Fetch users
        $userData = $this->userService->fetchUsers($allUsers);

        /**
         * Using an upsert like this will only store the password on insertions as
         * we don't want to update any existing passwords
         */
        User::upsert(
            array_map(fn ($user) => $user->toArray(), $userData->toArray()),
            'id',
            ['id', 'email', 'first_name', 'last_name', 'avatar']
        );
    }
}