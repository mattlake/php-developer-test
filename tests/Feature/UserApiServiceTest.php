<?php

namespace Tests\Feature;

use App\DataTransferObjects\ApiUserData;
use App\Services\UserAPIService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Tests\Fixtures\MockApiData;
use Tests\TestCase;

class UserApiServiceTest extends TestCase
{
    public function test_that_the_fetch_users_method_returns_an_array_of_ApiUserData_objects(): void
    {
        Http::fake(
            ['*' => MockApiData::validResponse()]
        );

        $userApiService = new UserApiService();
        $users = $userApiService->fetchUsers();

        $this->assertIsArray($users);
        $this->assertCount(3, $users);
        $this->assertInstanceOf(ApiUserData::class, $users[0]);
    }
}
