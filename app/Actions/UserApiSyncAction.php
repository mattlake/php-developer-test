<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use App\Services\UserAPIService;

class UserApiSyncAction
{
    private UserAPIService $userService;

    public function __construct()
    {
        // There are better ways to resolve this if the time allowed.
        $this->userService = resolve(UserAPIService::class);
    }

    public function handle()
    {
        // Fetch users
        $userData = $this->userService->fetchUsers();

        /**
         * Using an upsert like this will only store the password on insertions as
         * we don't want to update any existing passwords
         */
        User::upsert(
            array_map(fn ($user) => $user->toArray(), $userData),
            'id',
            ['id', 'email', 'first_name', 'last_name', 'avatar']
        );
    }
}