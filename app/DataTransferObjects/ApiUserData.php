<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

class ApiUserData
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $avatar,
        public readonly string $password,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => $this->avatar,
            'password' => $this->password,
        ];
    }
}