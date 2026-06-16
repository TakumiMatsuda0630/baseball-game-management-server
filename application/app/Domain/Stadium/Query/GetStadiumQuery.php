<?php

declare(strict_types=1);

namespace Application\Domain\Stadium\Query;

use Application\Models\Stadium as StadiumModel;

readonly class GetStadiumQuery
{
    /**
     * 球場一覧の取得
     * @return ?array<string, int|string>
     */
    public function getStadiumById(int $id): ?array
    {
        $stadium = StadiumModel::query()
            ->select('id', 'stadium_name')
            ->where('id', '=', $id)
            ->first();

        if ($stadium === null) {
            return null;
        }

        // TODO Read Modelのインスタンスを返却するようにしたい.
        return [
            'id' => $stadium->id,
            'stadium_name' => $stadium->stadium_name,
    ];
    }
}
