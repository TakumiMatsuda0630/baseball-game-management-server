<?php

declare(strict_types=1);

namespace Application\Domain\GameSchedule\UseCase;

use Application\Domain\GameSchedule\GameScheduleRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

readonly class DeleteGameScheduleUseCase
{
    public function __construct(private GameScheduleRepositoryInterface $repository)
    {
    }

    public function process(int $id): void
    {
        if (! $this->repository->delete($id)) {
            throw (new ModelNotFoundException())->setModel(\Application\Models\GameSchedule::class, [$id]);
        }
    }
}
