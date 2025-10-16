<?php

namespace Application\Adaptor\Stadium;

use Application\Domain\Stadium\StadiumFactoryInterface;
use Application\Domain\Stadium\ValueObject\StadiumName;
use Application\Domain\Stadium\ValueObject\StadiumId;
use Application\Domain\Stadium\Entity\Stadium;
use Application\Models\Stadium as StadiumModel;

class StadiumFactory implements StadiumFactoryInterface
{
    /**
     * 球場エンティティの生成
     *
     * @param string $stadiumName
     * @return Stadium
     */
    public function createStadium(string $stadiumName): Stadium
    {
        $stadiumId = $this->generateStadiumId();

        return new Stadium(
            new StadiumId($stadiumId),
            new StadiumName($stadiumName)
        );
    }

    /**
     * 球場IDの自動生成
     *
     * @return int
     */
    private function generateStadiumId(): int
    {
        $maxId = StadiumModel::max('id');
        return $maxId ? $maxId + 1 : 1;
    }
}