<?php

namespace App\Tests\Units;

use App\classes\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
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
        $reflection = new \ReflectionClass($a);
        $reflection_property = $reflection->getProperty('create_date');
        $reflection_property->setAccessible(true);

        $reflection_property->setValue($a, new \DateTimeImmutable('- 1 hour'));

        $this->expectException(\InvalidArgumentException::class);

        $a->getToken();
    }
}
