<?php

declare(strict_types=1);

namespace Application\Domain\Stadium\UseCase;

class UpdateStadiumInput
{
    /**
     * @param int $id 球場ID
     * @param string $name 球場名
     */
    public function __construct(
        private int $id,
        private string $name,
    ) {
    }

    /**
     * 球場IDを取得
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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