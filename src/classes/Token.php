<?php

namespace App\classes;

class Token
{
    private string $token;
    private \DateTimeImmutable $create_date;


    public function __construct()
    {
        $bytes = random_bytes(50);
        $hex = bin2hex($bytes);
        $token = mb_substr($hex, 0, 50);

        if (mb_strlen($token) < 50) {
            throw new \InvalidArgumentException('Токен не сгенерирован');
        }

        $this->token = $token;
        $this->create_date = new \DateTimeImmutable('+ 2 hour');
    }

    public function equals(string $token): bool
    {
        return $this->token === $token;
    }

    public function getToken(): string
    {
        $this->validateTimeOut();

        return $this->token;
    }

    /**
     * Проверка на истечение срока жизни токена
     */
    private function validateTimeOut(): void
    {
        if ($this->create_date->getTimestamp() < (new \DateTimeImmutable())->getTimestamp()) {
            throw new \InvalidArgumentException('Срок жизни токена истек');
        }
    }
}

