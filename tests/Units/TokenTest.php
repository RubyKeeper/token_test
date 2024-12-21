<?php

namespace App\Tests\Units;

use App\ValueObjects\Token;
use PHPUnit\Framework\TestCase;

final class TokenTest extends TestCase
{
    public function testToken(): void
    {
        $token = new Token();
        $this->assertInstanceOf(Token::class, $token);
    }

    public function testLenghtToken(): void
    {
        $token = new Token();
        $this->assertEquals(50, mb_strlen($token->getToken()));
    }

    public function testCreateConfiguredMock(): void
    {
        $a = new Token();
        $reflection_method = new \ReflectionMethod("App\ValueObjects\Token", "assertExpireTime");
        $reflection_method->setAccessible(true);

        $this->expectException(\InvalidArgumentException::class);

        $reflection_method->invoke($a, new \DateTimeImmutable('+ 3 hour'));
    }
}
