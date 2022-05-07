<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SyncUserCommandTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_the_sync_users_command_returns_0()
    {
        $this->artisan('sync:users')->assertExitCode(0);
    }

    public function test_that_the_sync_users_command_creates_users(): void
    {
        Http::fake(
            ['*' => $this->validApiResponseData()]
        );

        $this->artisan('sync:users');

        $this->assertCount(3,User::all());
    }

    private function validApiResponseData(): array
    {
        return [
            "page" => 1,
            "per_page" => 3,
            "total" => 12,
            "total_pages" => 4,
            "data" => [
                [
                    "id" => 1,
                    "email" => "george.bluth@reqres.in",
                    "first_name" => "George",
                    "last_name" => "Bluth",
                    "avatar" => "https://reqres.in/img/faces/1-image.jpg"
                ],
                [
                    "id" => 2,
                    "email" => "janet.weaver@reqres.in",
                    "first_name" => "Janet",
                    "last_name" => "Weaver",
                    "avatar" => "https://reqres.in/img/faces/2-image.jpg"
                ],
                [
                    "id" => 3,
                    "email" => "emma.wong@reqres.in",
                    "first_name" => "Emma",
                    "last_name" => "Wong",
                    "avatar" => "https://reqres.in/img/faces/3-image.jpg"
                ]
            ],
            "support" => [
                "url" => "https://reqres.in/#support-heading",
                "text" => "To keep ReqRes free, contributions towards server costs are appreciated!"
            ]
        ];
    }
}
