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

        $userApiService = new UserAPIService();
        $users = $userApiService->fetchUsers();

        $this->assertInstanceOf(Collection::class, $users);
        $this->assertCount(3, $users);
        $this->assertInstanceOf(ApiUserData::class, $users[0]);
    }

    public function test_that_the_fetch_users_method_sends_the_expected_request_when_the_all_flag_is_used()
    {
        Http::fake(
            ['*' => MockApiData::validResponse()]
        );

        $userApiService = new UserAPIService();
        $userApiService->fetchUsers(true);

        Http::assertSent(fn ($request) => $request->url() === 'https://reqres.in/api/users?page=1&per_page=100');
        Http::assertSent(fn ($request) => $request->url() === 'https://reqres.in/api/users?page=2&per_page=100');
        Http::assertSent(fn ($request) => $request->url() === 'https://reqres.in/api/users?page=3&per_page=100');
        Http::assertSent(fn ($request) => $request->url() === 'https://reqres.in/api/users?page=4&per_page=100');
    }

    public function test_that_the_fetch_users_method_returns_an_array_of_ApiUserData_objects_when_the_all_flag_is_used(
    ): void
    {
        Http::fake(
            ['*' => MockApiData::validResponse()]
        );

        $userApiService = new UserAPIService();
        $users = $userApiService->fetchUsers(true);

        $this->assertInstanceOf(Collection::class, $users);
        $this->assertCount(12, $users);
        $this->assertInstanceOf(ApiUserData::class, $users->first());
    }
}
