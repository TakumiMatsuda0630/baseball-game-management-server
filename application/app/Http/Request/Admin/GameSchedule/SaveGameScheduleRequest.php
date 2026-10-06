<?php

declare(strict_types=1);

namespace Application\Http\Request\Admin\GameSchedule;

use Illuminate\Foundation\Http\FormRequest;

class SaveGameScheduleRequest extends FormRequest
{
    /** @return array<string, list<string>> */
    public function rules(): array
    {
        return [
            'first_base_team_id' => ['required', 'uuid', 'exists:teams,id', 'different:third_base_team_id'],
            'third_base_team_id' => ['required', 'uuid', 'exists:teams,id'],
            'stadium_id' => ['required', 'integer', 'exists:stadiums,id'],
            'game_date' => ['required', 'date_format:Y-m-d'],
            'scheduled_start_time' => ['required', 'date_format:H:i'],
        ];
    }

    /** @return array{first_base_team_id: string, third_base_team_id: string, stadium_id: int, game_date: string, scheduled_start_time: string} */
    public function attributes(): array
    {
        return [
            'first_base_team_id' => $this->string('first_base_team_id')->toString(),
            'third_base_team_id' => $this->string('third_base_team_id')->toString(),
            'stadium_id' => $this->integer('stadium_id'),
            'game_date' => $this->string('game_date')->toString(),
            'scheduled_start_time' => $this->string('scheduled_start_time')->toString(),
        ];
    }
}
