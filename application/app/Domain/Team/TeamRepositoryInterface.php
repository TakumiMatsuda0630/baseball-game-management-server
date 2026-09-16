<?php

declare(strict_types=1);

namespace Application\Domain\Team;

use Application\Domain\Team\Entity\Team;
use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;

interface TeamRepositoryInterface
{
    /**
     * 指定したIDのチームを取得する。
     */
    public function getTeamById(TeamId $id): ?Team;

    /**
     * 指定したチーム名が既に使用されているか判定する。
     *
     * 更新時は除外対象のチームIDを指定できる。
     */
    public function existsByName(TeamName $name, ?TeamId $excludeId = null): bool;

    /**
     * 新しいチームを永続化する。
     */
    public function add(Team $team): void;

    /**
     * 永続化済みチームの現在の状態を更新する。
     */
    public function save(Team $team): void;

    /**
     * 指定したチームを永続化先から削除する。
     */
    public function delete(Team $team): void;
}
