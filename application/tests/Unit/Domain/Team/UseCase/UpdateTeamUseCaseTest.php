<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Team\UseCase;

use Application\Domain\Team\Entity\Team;
use Application\Domain\Team\Exception\DuplicateTeamNameException;
use Application\Domain\Team\Exception\TeamNotFoundException;
use Application\Domain\Team\TeamRepositoryInterface;
use Application\Domain\Team\UseCase\UpdateTeamInput;
use Application\Domain\Team\UseCase\UpdateTeamUseCase;
use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;
use PHPUnit\Framework\TestCase;

class UpdateTeamUseCaseTest extends TestCase
{
    private const TEAM_ID = '550e8400-e29b-41d4-a716-446655440001';

    public function test_it_updates_team(): void
    {
        $team = new Team(new TeamId(self::TEAM_ID), new TeamName('変更前'));
        $repository = $this->createMock(TeamRepositoryInterface::class);
        $repository->expects($this->once())->method('getTeamById')->willReturn($team);
        $repository->expects($this->once())->method('existsByName')->willReturn(false);
        $repository->expects($this->once())->method('save')->with($team);

        (new UpdateTeamUseCase($repository))->process(new UpdateTeamInput(self::TEAM_ID, '変更後'));

        $this->assertSame('変更後', (string) $team->name());
    }

    public function test_it_rejects_missing_team(): void
    {
        $repository = $this->createMock(TeamRepositoryInterface::class);
        $repository->expects($this->once())->method('getTeamById')->willReturn(null);

        $this->expectException(TeamNotFoundException::class);

        (new UpdateTeamUseCase($repository))->process(new UpdateTeamInput(self::TEAM_ID, '変更後'));
    }

    public function test_it_rejects_duplicate_name(): void
    {
        $team = new Team(new TeamId(self::TEAM_ID), new TeamName('変更前'));
        $repository = $this->createMock(TeamRepositoryInterface::class);
        $repository->expects($this->once())->method('getTeamById')->willReturn($team);
        $repository->expects($this->once())->method('existsByName')->willReturn(true);
        $repository->expects($this->never())->method('save');

        $this->expectException(DuplicateTeamNameException::class);

        (new UpdateTeamUseCase($repository))->process(new UpdateTeamInput(self::TEAM_ID, '登録済み'));
    }
}
