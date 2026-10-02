<?php

declare(strict_types=1);

namespace Application\Domain\Team\UseCase;

use Application\Domain\Team\Exception\TeamNotFoundException;
use Application\Domain\Team\TeamRepositoryInterface;
use Application\Domain\Team\ValueObject\TeamId;

readonly class DeleteTeamUseCase
{
    public function __construct(private TeamRepositoryInterface $teamRepository)
    {
    }

    /**
     * 対象チームの存在を検証し、チームを削除する。
     */
    public function process(DeleteTeamInput $input): void
    {
        $team = $this->teamRepository->getTeamById(new TeamId($input->getId()));

        if ($team === null) {
            throw new TeamNotFoundException();
        }

        $this->teamRepository->delete($team);
    }
}
