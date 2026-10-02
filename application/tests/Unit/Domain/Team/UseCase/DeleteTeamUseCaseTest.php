<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Team\UseCase;

use Application\Domain\Team\Entity\Team;
use Application\Domain\Team\Exception\TeamNotFoundException;
use Application\Domain\Team\TeamRepositoryInterface;
use Application\Domain\Team\UseCase\DeleteTeamInput;
use Application\Domain\Team\UseCase\DeleteTeamUseCase;
use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;
use PHPUnit\Framework\TestCase;

class DeleteTeamUseCaseTest extends TestCase
{
    private const TEAM_ID = '550e8400-e29b-41d4-a716-446655440001';

    public function test_it_deletes_team(): void
    {
        $team = new Team(new TeamId(self::TEAM_ID), new TeamName('チームA'));
        $repository = $this->createMock(TeamRepositoryInterface::class);
        $repository->expects($this->once())->method('getTeamById')->willReturn($team);
        $repository->expects($this->once())->method('delete')->with($team);

        (new DeleteTeamUseCase($repository))->process(new DeleteTeamInput(self::TEAM_ID));
    }

    public function test_it_rejects_missing_team(): void
    {
        $repository = $this->createMock(TeamRepositoryInterface::class);
        $repository->expects($this->once())->method('getTeamById')->willReturn(null);

        $this->expectException(TeamNotFoundException::class);

        (new DeleteTeamUseCase($repository))->process(new DeleteTeamInput(self::TEAM_ID));
    }
}
