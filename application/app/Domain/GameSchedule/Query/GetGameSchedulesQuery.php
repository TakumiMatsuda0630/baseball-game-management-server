<?php

declare(strict_types=1);

namespace Application\Domain\GameSchedule\Query;

use Application\Models\GameSchedule;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

readonly class GetGameSchedulesQuery
{
    /**
     * @param array{game_dates?: list<string>, scheduled_start_times?: list<string>, team_ids?: list<string>, stadium_ids?: list<int>} $filters
     * @return LengthAwarePaginator<int, object>
     */
    public function paginate(array $filters): LengthAwarePaginator
    {
        $query = DB::table('game_schedules as schedules')
            ->join('teams as first_team', 'first_team.id', '=', 'schedules.first_base_team_id')
            ->join('teams as third_team', 'third_team.id', '=', 'schedules.third_base_team_id')
            ->join('stadiums', 'stadiums.id', '=', 'schedules.stadium_id')
            ->select([
                'schedules.id', 'schedules.game_date', 'schedules.scheduled_start_time',
                'schedules.first_base_team_id', 'schedules.third_base_team_id', 'schedules.stadium_id',
                'first_team.team_name as first_base_team_name',
                'third_team.team_name as third_base_team_name',
                'stadiums.stadium_name',
            ]);

        if (($filters['game_dates'] ?? []) !== []) {
            $query->whereIn('schedules.game_date', $filters['game_dates']);
        }
        if (($filters['scheduled_start_times'] ?? []) !== []) {
            $times = $filters['scheduled_start_times'];
            $query->whereIn('schedules.scheduled_start_time', [
                ...$times,
                ...array_map(static fn (string $time): string => $time.':00', $times),
            ]);
        }
        if (($filters['stadium_ids'] ?? []) !== []) {
            $query->whereIn('schedules.stadium_id', $filters['stadium_ids']);
        }
        if (($filters['team_ids'] ?? []) !== []) {
            $teamIds = $filters['team_ids'];
            $query->where(static function (Builder $query) use ($teamIds): void {
                $query->whereIn('schedules.first_base_team_id', $teamIds)
                    ->orWhereIn('schedules.third_base_team_id', $teamIds);
            });
        }

        /** @var LengthAwarePaginator<int, object> $page */
        $page = $query->orderBy('schedules.game_date')
            ->orderBy('schedules.stadium_id')
            ->orderBy('schedules.scheduled_start_time')
            ->orderBy('schedules.id')
            ->paginate(20)
            ->withQueryString();

        return $page;
    }

    public function find(int $id): ?GameSchedule
    {
        return GameSchedule::query()->find($id);
    }
}
