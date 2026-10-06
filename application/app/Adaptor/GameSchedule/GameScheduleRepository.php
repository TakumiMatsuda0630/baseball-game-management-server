<?php

declare(strict_types=1);

namespace Application\Adaptor\GameSchedule;

use Application\Domain\GameSchedule\GameScheduleRepositoryInterface;
use Application\Models\GameSchedule;

readonly class GameScheduleRepository implements GameScheduleRepositoryInterface
{
    public function __construct(private GameSchedule $model)
    {
    }

    public function add(array $attributes): void
    {
        $this->model::query()->create($attributes);
    }

    public function save(int $id, array $attributes): bool
    {
        return $this->model::query()->whereKey($id)->update($attributes) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->model::query()->whereKey($id)->delete() > 0;
    }
}
