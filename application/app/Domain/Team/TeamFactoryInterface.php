<?php

declare(strict_types=1);

namespace Application\Domain\Team;

use Application\Domain\Team\Entity\Team;
use Application\Domain\Team\ValueObject\TeamName;

interface TeamFactoryInterface
{
    /**
     * 新規登録用のチームエンティティを生成する。
     */
    public function createTeam(TeamName $teamName): Team;
}
