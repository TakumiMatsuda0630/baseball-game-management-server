<?php

declare(strict_types=1);

namespace Application\Domain\GameSchedule;

interface GameScheduleRepositoryInterface
{
    /** @param array{first_base_team_id: string, third_base_team_id: string, stadium_id: int, game_date: string, scheduled_start_time: string} $attributes */
    public function add(array $attributes): void;

    /** @param array{first_base_team_id: string, third_base_team_id: string, stadium_id: int, game_date: string, scheduled_start_time: string} $attributes */
    public function save(int $id, array $attributes): bool;

    public function delete(int $id): bool;
}
