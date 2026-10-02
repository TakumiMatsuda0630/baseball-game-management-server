<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Team\Entity;

use Application\Domain\Team\Entity\Team;
use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    public function test_it_exposes_and_changes_its_values(): void
    {
        $id = '550e8400-e29b-41d4-a716-446655440001';
        $team = new Team(new TeamId($id), new TeamName('変更前'));

        $this->assertSame($id, (string) $team->id());
        $this->assertSame('変更前', (string) $team->name());
        $this->assertSame(['id' => $id, 'name' => '変更前'], $team->toArray());

        $team->rename(new TeamName('変更後'));

        $this->assertSame('変更後', (string) $team->name());
    }
}
