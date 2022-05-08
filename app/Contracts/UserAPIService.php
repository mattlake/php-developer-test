<?php

namespace App\Contracts;

use App\DataTransferObjects\ApiUserData;
use Illuminate\Support\Collection;

interface UserAPIService
{
    /**
     * @param bool $allUsers
     * @return Collection<ApiUserData>
     */
    public function fetchUsers(bool $allUsers = false): Collection;
}