<?php

declare(strict_types=1);

namespace Application\Http\Request\Admin\GameSchedule;

use Illuminate\Foundation\Http\FormRequest;

class SearchGameSchedulesRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'game_dates' => ['sometimes', 'array'],
            'game_dates.*' => ['required', 'date_format:Y-m-d'],
            'scheduled_start_times' => ['sometimes', 'array'],
            'scheduled_start_times.*' => ['required', 'date_format:H:i'],
            'team_ids' => ['sometimes', 'array'],
            'team_ids.*' => ['required', 'uuid', 'exists:teams,id'],
            'stadium_ids' => ['sometimes', 'array'],
            'stadium_ids.*' => ['required', 'integer', 'exists:stadiums,id'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    /** @return array{game_dates: list<string>, scheduled_start_times: list<string>, team_ids: list<string>, stadium_ids: list<int>} */
    public function filters(): array
    {
        $validated = $this->validated();
        /** @var list<string> $gameDates */
        $gameDates = $validated['game_dates'] ?? [];
        /** @var list<string> $startTimes */
        $startTimes = $validated['scheduled_start_times'] ?? [];
        /** @var list<string> $teamIds */
        $teamIds = $validated['team_ids'] ?? [];
        /** @var list<int|string> $stadiumIds */
        $stadiumIds = $validated['stadium_ids'] ?? [];

        return [
            'game_dates' => $gameDates,
            'scheduled_start_times' => $startTimes,
            'team_ids' => $teamIds,
            'stadium_ids' => array_map(static fn (int|string $id): int => (int) $id, $stadiumIds),
        ];
    }
}
