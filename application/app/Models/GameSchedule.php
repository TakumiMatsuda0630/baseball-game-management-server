<?php

declare(strict_types=1);

namespace Application\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $first_base_team_id
 * @property string $third_base_team_id
 * @property int $stadium_id
 * @property string $game_date
 * @property string $scheduled_start_time
 */
class GameSchedule extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'first_base_team_id',
        'third_base_team_id',
        'stadium_id',
        'game_date',
        'scheduled_start_time',
    ];
}
