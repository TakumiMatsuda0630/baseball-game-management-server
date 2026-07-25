<?php

declare(strict_types=1);

namespace Application\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $stadium_name
 */
class Stadium extends Model
{
    /**
     * @var string
     */
    protected $table = 'stadiums';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'stadium_name',
    ];
}
