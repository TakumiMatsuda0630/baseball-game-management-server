<?php

declare(strict_types=1);

namespace Application\Domain\GameSchedule\UseCase;

use Application\Domain\GameSchedule\GameScheduleRepositoryInterface;

readonly class StoreGameScheduleUseCase
{
    public function __construct(private GameScheduleRepositoryInterface $repository)
    {
    }

    /** @param array{first_base_team_id: string, third_base_team_id: string, stadium_id: int, game_date: string, scheduled_start_time: string} $attributes */
    public function process(array $attributes): void
    {
        $this->repository->add($attributes);
    }
}
