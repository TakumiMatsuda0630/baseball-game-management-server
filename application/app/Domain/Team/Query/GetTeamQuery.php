<?php

declare(strict_types=1);

namespace Application\Domain\Team\Query;

use Application\Models\Team as TeamModel;

readonly class GetTeamQuery
{
    /**
     * 指定したIDのチームを参照用データとして取得する。
     *
     * @return array{id: string, team_name: string}|null
     */
    public function getTeamById(string $id): ?array
    {
        $team = TeamModel::query()
            ->select('id', 'team_name')
            ->find($id);

        if ($team === null) {
            return null;
        }

        return [
            'id' => $team->id,
            'team_name' => $team->team_name,
        ];
    }
}
