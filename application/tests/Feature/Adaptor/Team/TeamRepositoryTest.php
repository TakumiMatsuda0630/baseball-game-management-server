<?php

declare(strict_types=1);

namespace Tests\Feature\Adaptor\Team;

use Application\Domain\Team\Entity\Team;
use Application\Domain\Team\Exception\DuplicateTeamNameException;
use Application\Domain\Team\TeamRepositoryInterface;
use Application\Domain\Team\ValueObject\TeamId;
use Application\Domain\Team\ValueObject\TeamName;
use Application\Models\Team as TeamModel;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private const TEAM_ID = '550e8400-e29b-41d4-a716-446655440001';

    private const ANOTHER_TEAM_ID = '550e8400-e29b-41d4-a716-446655440002';

    private TeamRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(TeamRepositoryInterface::class);
    }

    public function test_it_gets_team_by_id(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        $team = $this->repository->getTeamById(new TeamId(self::TEAM_ID));

        $this->assertNotNull($team);
        $this->assertSame(self::TEAM_ID, (string) $team->id());
        $this->assertSame('チームA', (string) $team->name());
    }

    public function test_it_returns_null_for_missing_team(): void
    {
        $this->assertNull($this->repository->getTeamById(new TeamId(self::TEAM_ID)));
    }

    public function test_it_detects_name_and_can_exclude_current_team(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        $this->assertTrue($this->repository->existsByName(new TeamName('チームA')));
        $this->assertFalse($this->repository->existsByName(new TeamName('チームA'), new TeamId(self::TEAM_ID)));
        $this->assertFalse($this->repository->existsByName(new TeamName('チームB')));
    }

    public function test_it_creates_and_updates_team(): void
    {
        $team = new Team(new TeamId(self::TEAM_ID), new TeamName('変更前'));
        $this->repository->add($team);
        $this->assertDatabaseHas('teams', ['id' => self::TEAM_ID, 'team_name' => '変更前']);

        $team->rename(new TeamName('変更後'));
        $this->repository->save($team);

        $this->assertDatabaseCount('teams', 1);
        $this->assertDatabaseHas('teams', ['id' => self::TEAM_ID, 'team_name' => '変更後']);
    }

    public function test_add_does_not_overwrite_an_existing_team(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        try {
            $this->repository->add(
                new Team(new TeamId(self::TEAM_ID), new TeamName('チームB')),
            );
            $this->fail('同じIDのチームを追加できてしまいました。');
        } catch (QueryException) {
            $this->assertDatabaseHas('teams', [
                'id' => self::TEAM_ID,
                'team_name' => 'チームA',
            ]);
        }
    }

    public function test_it_deletes_team(): void
    {
        $team = new Team(new TeamId(self::TEAM_ID), new TeamName('チームA'));
        $this->repository->add($team);

        $this->repository->delete($team);

        $this->assertDatabaseMissing('teams', ['id' => self::TEAM_ID]);
    }

    public function test_add_translates_duplicate_name_violation_to_domain_exception(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        $this->expectException(DuplicateTeamNameException::class);

        $this->repository->add(
            new Team(new TeamId(self::ANOTHER_TEAM_ID), new TeamName('チームA')),
        );
    }

    public function test_save_translates_duplicate_name_violation_to_domain_exception(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);
        $team = new Team(new TeamId(self::ANOTHER_TEAM_ID), new TeamName('チームB'));
        $this->repository->add($team);
        $team->rename(new TeamName('チームA'));

        $this->expectException(DuplicateTeamNameException::class);

        $this->repository->save($team);
    }
}
