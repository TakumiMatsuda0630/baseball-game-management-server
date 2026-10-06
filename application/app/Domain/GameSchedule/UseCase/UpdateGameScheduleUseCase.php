<?php

declare(strict_types=1);

namespace Application\Domain\GameSchedule\UseCase;

use Application\Domain\GameSchedule\GameScheduleRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

readonly class UpdateGameScheduleUseCase
{
    public function __construct(private GameScheduleRepositoryInterface $repository)
    {
    }

    /** @param array{first_base_team_id: string, third_base_team_id: string, stadium_id: int, game_date: string, scheduled_start_time: string} $attributes */
    public function process(int $id, array $attributes): void
    {
        if (! $this->repository->save($id, $attributes)) {
            throw (new ModelNotFoundException())->setModel(\Application\Models\GameSchedule::class, [$id]);
        }
    }
}
