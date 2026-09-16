<?php

declare(strict_types=1);

namespace Tests\Feature\Domain\Team\Query;

use Application\Domain\Team\Query\GetTeamQuery;
use Application\Domain\Team\Query\GetTeamsQuery;
use Application\Models\Team as TeamModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamQueryTest extends TestCase
{
    use RefreshDatabase;

    private const TEAM_ID = '550e8400-e29b-41d4-a716-446655440001';

    private const ANOTHER_TEAM_ID = '550e8400-e29b-41d4-a716-446655440002';

    public function test_it_gets_team_by_id(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        $this->assertSame(
            ['id' => self::TEAM_ID, 'team_name' => 'チームA'],
            (new GetTeamQuery())->getTeamById(self::TEAM_ID),
        );
    }

    public function test_it_returns_null_for_missing_team(): void
    {
        $this->assertNull((new GetTeamQuery())->getTeamById(self::TEAM_ID));
    }

    public function test_it_gets_teams_in_id_order(): void
    {
        TeamModel::query()->create(['id' => self::ANOTHER_TEAM_ID, 'team_name' => 'チームB']);
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        $this->assertSame([
            ['id' => self::TEAM_ID, 'team_name' => 'チームA'],
            ['id' => self::ANOTHER_TEAM_ID, 'team_name' => 'チームB'],
        ], (new GetTeamsQuery())->getTeams());
    }
}
