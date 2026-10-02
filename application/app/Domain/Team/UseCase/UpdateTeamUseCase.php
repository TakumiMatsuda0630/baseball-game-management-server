<?php

declare(strict_types=1);

namespace Application\Domain\Team\UseCase;

use Application\Domain\Team\Exception\DuplicateTeamNameException;
use Application\Domain\Team\Exception\TeamNotFoundException;
use Application\Domain\Team\TeamRepositoryInterface;
use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;

readonly class UpdateTeamUseCase
{
    public function __construct(private TeamRepositoryInterface $teamRepository)
    {
    }

    /**
     * 対象チームの存在と名称の重複を検証し、チーム名を変更する。
     */
    public function process(UpdateTeamInput $input): void
    {
        $teamId = new TeamId($input->getId());
        $team = $this->teamRepository->getTeamById($teamId);

        if ($team === null) {
            throw new TeamNotFoundException();
        }

        $teamName = new TeamName($input->getName());
        if ($this->teamRepository->existsByName($teamName, $teamId)) {
            throw new DuplicateTeamNameException();
        }

        $team->rename($teamName);
        $this->teamRepository->save($team);
    }
}
