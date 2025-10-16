<?php

declare(strict_types=1);

namespace Application\Domain\Stadium\UseCase;

class StoreStadiumInput
{
    /**
     * @param string $name 球場名
     */
    public function __construct(
        private string $name,
    ) {
    }

    /**
     * 球場名を取得
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}