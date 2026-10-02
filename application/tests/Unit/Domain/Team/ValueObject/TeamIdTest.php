<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Team\ValueObject;

use Application\Domain\Team\ValueObject\TeamId;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TeamIdTest extends TestCase
{
    public function test_it_keeps_valid_id(): void
    {
        $id = '550e8400-e29b-41d4-a716-446655440000';
        $teamId = new TeamId($id);

        $this->assertSame($id, (string) $teamId);
    }

    #[DataProvider('invalidIds')]
    public function test_it_rejects_invalid_id(string $id): void
    {
        $this->expectException(InvalidArgumentException::class);

        new TeamId($id);
    }

    /** @return array<string, array{string}> */
    public static function invalidIds(): array
    {
        return [
            'empty' => [''],
            'non-UUID' => ['1'],
            'invalid variant' => ['550e8400-e29b-41d4-7716-446655440000'],
        ];
    }
}
