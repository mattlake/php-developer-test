<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SyncUserCommandTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_that_the_sync_users_command_returns_0(): void
    {
        $this->artisan('sync:users')->assertExitCode(0);
    }
}
