<?php

namespace Tests\Feature;

use App\Actions\UserApiSyncAction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Tests\Fixtures\MockApiData;
use Tests\TestCase;

class UserApiSyncActionTest extends TestCase
{
    public function test_that_the_sync_users_command_creates_users(): void
    {
        Http::fake(
            ['*' => MockApiData::validResponse()]
        );

        $action = new UserApiSyncAction();
        $action->handle();

        $this->assertCount(3, User::all());
    }

    public function test_that_exception_is_thrown_when_response_is_a_400_status()
    {
        Http::fake(
            ['*' => Http::response([], 404)]
        );

        $this->expectException(Exception::class);

        $action = new UserApiSyncAction();
        $action->handle();
    }

    public function test_that_exception_is_thrown_when_response_is_a_500_status()
    {
        Http::fake(
            ['*' => Http::response([], 500)]
        );

        $this->expectException(Exception::class);

        $action = new UserApiSyncAction();
        $action->handle();
    }
}
