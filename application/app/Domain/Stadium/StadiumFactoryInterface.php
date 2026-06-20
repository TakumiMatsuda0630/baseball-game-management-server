<?php

declare(strict_types=1);

namespace Application\Domain\Stadium;

use Application\Domain\Stadium\Entity\Stadium;

interface StadiumFactoryInterface
{
    /**
     * 球場エンティティの生成
     * @param string $stadiumName
     * @return Stadium
     */
    public function createStadium(string $stadiumName): Stadium;

}
