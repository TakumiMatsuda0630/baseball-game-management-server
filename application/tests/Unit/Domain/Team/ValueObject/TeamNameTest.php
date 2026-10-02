<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Team\ValueObject;

use Application\Domain\Team\ValueObject\TeamName;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TeamNameTest extends TestCase
{
    public function test_it_keeps_valid_name(): void
    {
        $name = str_repeat('あ', 100);

        $this->assertSame($name, (string) new TeamName($name));
    }

    #[DataProvider('invalidNames')]
    public function test_it_rejects_invalid_name(string $name): void
    {
        $this->expectException(InvalidArgumentException::class);

        new TeamName($name);
    }

    /** @return array<string, array{string}> */
    public static function invalidNames(): array
    {
        return [
            'empty' => [''],
            'too long' => [str_repeat('a', 101)],
        ];
    }
}
