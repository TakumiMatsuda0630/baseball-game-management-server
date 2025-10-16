<?php

declare(strict_types=1);

namespace Application\Adaptor\Stadium;

use Application\Domain\Stadium\Entity\Stadium;
use Application\Domain\Stadium\ValueObject\StadiumId;
use Application\Domain\Stadium\ValueObject\StadiumName;
use Application\Domain\Stadium\StadiumRepositoryInterface;
use Application\Models\Stadium as StadiumModel;

readonly class StadiumRepository implements StadiumRepositoryInterface
{
    public function __construct(
        private StadiumModel $stadiumModel
    ) {
    }

    /**
     * 球場を取得
     * @param StadiumId $id
     * @return ?Stadium
     */
    public function getStadiumById(StadiumId $id): ?Stadium
    {
        $stadiumData = $this->stadiumModel::query()
            ->select('id', 'stadium_name')
            ->where('id', '=', $id->toInt())
            ->first();

        if (!$stadiumData) {
            null;
        }

        return new Stadium(
            new StadiumId((int) $stadiumData->id),
            new StadiumName((string) $stadiumData->stadium_name)
        );
    }

    /**
     * 球場の保存
     * @param Stadium $stadium
     */
    public function save(Stadium $stadium): void
    {
        $this->stadiumModel::query()
            ->updateOrCreate(
                ['id' => $stadium->id()],
                ['stadium_name' => $stadium->name()]
            );
    }

    /**
     * 球場の削除
     * @param StadiumId $id
     */
    public function delete(Stadium $stadium): void
    {
        $this->stadiumModel::query()
            ->where('id', '=', $stadium->id()->toInt())
            ->delete();
    }
}
