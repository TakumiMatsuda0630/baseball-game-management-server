<?php

declare(strict_types=1);

namespace Application\Domain\Stadium;

use Application\Domain\Stadium\Entity\Stadium;
use Application\Domain\Stadium\ValueObject\StadiumId;

interface StadiumRepositoryInterface
{
    /**
     * 球場を取得
     * @param StadiumId $id
     * @return ?Stadium
     */
    public function getStadiumById(StadiumId $id): ?Stadium;

    /**
     * 球場の保存
     * @param Stadium $stadium
     */
    public function save(Stadium $stadium): void;

    /**
     * 球場の削除
     * @param StadiumId $id
     */
    public function delete(Stadium $stadium): void;
}