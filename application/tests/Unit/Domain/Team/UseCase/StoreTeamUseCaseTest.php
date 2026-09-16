<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Team\UseCase;

use Application\Domain\Team\Entity\Team;
use Application\Domain\Team\Exception\DuplicateTeamNameException;
use Application\Domain\Team\TeamFactoryInterface;
use Application\Domain\Team\TeamRepositoryInterface;
use Application\Domain\Team\UseCase\StoreTeamInput;
use Application\Domain\Team\UseCase\StoreTeamUseCase;
use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;
use PHPUnit\Framework\TestCase;

class StoreTeamUseCaseTest extends TestCase
{
    public function test_it_stores_new_team(): void
    {
        $teamName = new TeamName('チームA');
        $team = new Team(new TeamId('550e8400-e29b-41d4-a716-446655440001'), $teamName);
        $factory = $this->createMock(TeamFactoryInterface::class);
        $repository = $this->createMock(TeamRepositoryInterface::class);
        $repository->expects($this->once())->method('existsByName')->willReturn(false);
        $factory->expects($this->once())->method('createTeam')->with($teamName)->willReturn($team);
        $repository->expects($this->once())->method('add')->with($team);

        (new StoreTeamUseCase($factory, $repository))->process(new StoreTeamInput('チームA'));
    }

    public function test_it_rejects_duplicate_name(): void
    {
        $factory = $this->createMock(TeamFactoryInterface::class);
        $repository = $this->createMock(TeamRepositoryInterface::class);
        $repository->expects($this->once())->method('existsByName')->willReturn(true);
        $factory->expects($this->never())->method('createTeam');
        $repository->expects($this->never())->method('add');

        $this->expectException(DuplicateTeamNameException::class);

        (new StoreTeamUseCase($factory, $repository))->process(new StoreTeamInput('チームA'));
    }
}
