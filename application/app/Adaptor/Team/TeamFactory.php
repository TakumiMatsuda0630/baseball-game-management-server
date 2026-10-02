<?php

declare(strict_types=1);

namespace Application\Adaptor\Team;

use Application\Domain\Team\Entity\Team;
use Application\Domain\Team\TeamFactoryInterface;
use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;
use Illuminate\Support\Str;

class TeamFactory implements TeamFactoryInterface
{
    /**
     * UUIDを採番し、新規チームを生成する。
     */
    public function createTeam(TeamName $teamName): Team
    {
        return new Team(
            new TeamId((string) Str::uuid()),
            $teamName,
        );
    }
}
