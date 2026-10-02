<?php

declare(strict_types=1);

namespace Application\Domain\Team\Entity;

use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;

class Team
{
    public function __construct(
        private readonly TeamId $id,
        private TeamName $name,
    ) {
    }

    public function id(): TeamId
    {
        return $this->id;
    }

    public function name(): TeamName
    {
        return $this->name;
    }

    /**
     * チーム名を新しい名称へ変更する。
     */
    public function rename(TeamName $name): void
    {
        $this->name = $name;
    }

    /**
     * チームの現在の状態をプリミティブ値の配列へ変換する。
     *
     * @return array{id: string, name: string}
     */
    public function toArray(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => (string) $this->name,
        ];
    }
}
