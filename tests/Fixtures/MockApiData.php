<?php

declare(strict_types=1);

namespace Tests\Fixtures;

class MockApiData
{
    public static function validResponse(): array
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