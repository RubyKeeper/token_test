<?php

namespace App\ValueObjects;

use Random\RandomException;

final readonly class Token
{
    private string $token;
    private \DateTimeImmutable $expires_date; // срок жизни токена

    /**
     * @throws RandomException
     */
    public function __construct()
    {
        $bytes = random_bytes(50);
        $hex = bin2hex($bytes);
        $token = mb_substr($hex, 0, 50);

        if (mb_strlen($token) < 50) {
            throw new \InvalidArgumentException('Токен не сгенерирован');
        }

        $this->token = $token;
        $this->expires_date = new \DateTimeImmutable('+ 2 hour');
    }

    public function equals(string $token): bool
    {
        $this->assertExpireTime();
        return $this->token === $token;
    }

    /**
     * Проверка на истечение срока жизни токена
     */
    private function assertExpireTime(\DateTimeImmutable $date = null): void
    {
        $now_date = $date ?? new \DateTimeImmutable();
        if ($this->expires_date->getTimestamp() < ($now_date)->getTimestamp()) {
            throw new \InvalidArgumentException('Срок жизни токена истек');
        }
    }

    public function getToken(): string
    {
        $this->assertExpireTime();
        return $this->token;
    }
}

