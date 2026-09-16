<?php

declare(strict_types=1);

namespace Application\Adaptor\Team;

use Application\Domain\Team\Entity\Team;
use Application\Domain\Team\Exception\DuplicateTeamNameException;
use Application\Domain\Team\TeamRepositoryInterface;
use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;
use Application\Models\Team as TeamModel;
use Illuminate\Database\UniqueConstraintViolationException;

readonly class TeamRepository implements TeamRepositoryInterface
{
    public function __construct(private TeamModel $teamModel)
    {
    }

    public function getTeamById(TeamId $id): ?Team
    {
        $teamData = $this->teamModel::query()
            ->select('id', 'team_name')
            ->find((string) $id);

        if ($teamData === null) {
            return null;
        }

        return new Team(
            new TeamId((string) $teamData->id),
            new TeamName((string) $teamData->team_name),
        );
    }

    public function existsByName(TeamName $name, ?TeamId $excludeId = null): bool
    {
        $query = $this->teamModel::query()
            ->where('team_name', '=', (string) $name);

        if ($excludeId !== null) {
            $query->where('id', '!=', (string) $excludeId);
        }

        return $query->exists();
    }

    public function add(Team $team): void
    {
        try {
            $this->teamModel::query()->create([
                'id' => (string) $team->id(),
                'team_name' => (string) $team->name(),
            ]);
        } catch (UniqueConstraintViolationException $exception) {
            if ($this->existsByName($team->name())) {
                throw new DuplicateTeamNameException($exception);
            }

            throw $exception;
        }
    }

    public function save(Team $team): void
    {
        try {
            $this->teamModel::query()
                ->where('id', '=', (string) $team->id())
                ->update(['team_name' => (string) $team->name()]);
        } catch (UniqueConstraintViolationException $exception) {
            throw new DuplicateTeamNameException($exception);
        }
    }

    public function delete(Team $team): void
    {
        $this->teamModel::query()
            ->where('id', '=', (string) $team->id())
            ->delete();
    }
}
