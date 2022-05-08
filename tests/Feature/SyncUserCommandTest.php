<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\Fixtures\MockApiData;
use Tests\TestCase;

class SyncUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_the_sync_users_command_returns_0_with_first_page_of_users(): void
    {
        Http::fake(
            ['*' => MockApiData::validResponse()]
        );

        $this->artisan('sync:users')->assertExitCode(0);
    }

    public function test_that_the_sync_users_command_returns_0_with_all_users_flag(): void
    {
        Http::fake(
            ['*' => MockApiData::validResponse()]
        );

        $this->artisan('sync:users --all')->assertExitCode(0);
    }

    public function test_that_the_sync_users_command_returns_1_when_there_is_an_exception(): void
    {
        Http::fake(
            ['*' => Http::response([], 500)]
        );

        $this->artisan('sync:users')->assertExitCode(1);
    }
}
