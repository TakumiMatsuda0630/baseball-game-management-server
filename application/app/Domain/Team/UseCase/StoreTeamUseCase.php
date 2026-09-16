<?php

declare(strict_types=1);

namespace Application\Domain\Team\UseCase;

use Application\Domain\Team\Exception\DuplicateTeamNameException;
use Application\Domain\Team\TeamFactoryInterface;
use Application\Domain\Team\TeamRepositoryInterface;
use Application\Domain\Team\ValueObject\TeamName;

readonly class StoreTeamUseCase
{
    public function __construct(
        private TeamFactoryInterface $teamFactory,
        private TeamRepositoryInterface $teamRepository,
    ) {
    }

    /**
     * チーム名の重複を検証し、新しいチームを登録する。
     */
    public function process(StoreTeamInput $input): void
    {
        $teamName = new TeamName($input->getName());

        if ($this->teamRepository->existsByName($teamName)) {
            throw new DuplicateTeamNameException();
        }

        $this->teamRepository->add(
            $this->teamFactory->createTeam($teamName),
        );
    }
}
