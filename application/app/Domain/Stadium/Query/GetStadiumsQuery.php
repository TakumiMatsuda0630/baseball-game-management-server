<?php

declare(strict_types=1);

namespace Application\Domain\Stadium\Query;

use Application\Models\Stadium as StadiumModel;

readonly class GetStadiumsQuery
{
    /**
     * 球場一覧の取得
     * @return array<int, array<string, int|string>>
     */
    public function getStadiums(): array
    {
        // TODO Read Modelの配列形式で返却するようにしたい.
        /** @var array<int, array{id:int, stadium_name:string}> $stadiums */
        $stadiums = StadiumModel::query()
            ->select('id', 'stadium_name')
            ->get()
            ->toArray();

        return $stadiums;
    }
}
