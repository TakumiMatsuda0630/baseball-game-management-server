<?php

declare(strict_types=1);

namespace Tests\Feature\Adaptor\Team;

use Application\Domain\Team\TeamFactoryInterface;
use Application\Domain\Team\ValueObject\TeamName;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TeamFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_team_with_uuid(): void
    {
        $team = app(TeamFactoryInterface::class)->createTeam(new TeamName('チームA'));

        $this->assertTrue(Str::isUuid((string) $team->id()));
        $this->assertSame('チームA', (string) $team->name());
    }
}
