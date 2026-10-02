<?php

declare(strict_types=1);

namespace Application\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $team_name
 */
class Team extends Model
{
    protected $table = 'teams';

    public $incrementing = false;

    protected $keyType = 'string';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'team_name',
    ];
}
