<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SyncUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_the_sync_users_command_returns_0(): void
    {
        $this->artisan('sync:users')->assertExitCode(0);
    }

    public function test_that_the_sync_users_command_returns_1_when_there_is_an_exception(): void
    {
        Http::fake(
            ['*' => Http::response([], 500)]
        );

        $this->artisan('sync:users')->assertExitCode(1);
    }
}
