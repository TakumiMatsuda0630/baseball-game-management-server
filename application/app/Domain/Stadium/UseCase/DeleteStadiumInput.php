<?php

declare(strict_types=1);

namespace Application\Domain\Stadium\UseCase;

readonly class DeleteStadiumInput
{
    /**
     * @param int $id 球場ID
     */
    public function __construct(
        private int $id,
    ) {
    }

    /**
     * 球場IDを取得
     *
     * @return string
     */
    public function getId(): int
    {
        return $this->id;
    }
}