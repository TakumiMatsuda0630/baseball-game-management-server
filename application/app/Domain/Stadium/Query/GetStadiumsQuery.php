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
        $stadiums = StadiumModel::query()
            ->select('id', 'stadium_name')
            ->get();


        return $stadiums->toArray();
    }
}