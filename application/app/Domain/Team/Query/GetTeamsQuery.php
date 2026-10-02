<?php

declare(strict_types=1);

namespace Application\Domain\Team\Query;

use Application\Models\Team as TeamModel;

readonly class GetTeamsQuery
{
    /**
     * チーム一覧をIDの昇順で参照用データとして取得する。
     *
     * @return array<int, array{id: string, team_name: string}>
     */
    public function getTeams(): array
    {
        /** @var array<int, array{id: string, team_name: string}> $teams */
        $teams = TeamModel::query()
            ->select('id', 'team_name')
            ->orderBy('id')
            ->get()
            ->toArray();

        return $teams;
    }
}
