<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Admin;

use Application\Models\GameSchedule;
use Application\Models\Stadium;
use Application\Models\Team;
use Application\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class GameScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    private const FIRST_TEAM_ID = '550e8400-e29b-41d4-a716-446655440001';

    private const THIRD_TEAM_ID = '550e8400-e29b-41d4-a716-446655440002';

    private const OTHER_TEAM_ID = '550e8400-e29b-41d4-a716-446655440003';

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('app.key', 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=');
        $this->withoutVite();
        $this->actingAs(User::factory()->create());
        Team::query()->create(['id' => self::FIRST_TEAM_ID, 'team_name' => 'A']);
        Team::query()->create(['id' => self::THIRD_TEAM_ID, 'team_name' => 'B']);
        Team::query()->create(['id' => self::OTHER_TEAM_ID, 'team_name' => 'C']);
        Stadium::query()->create(['stadium_name' => '球場A']);
        Stadium::query()->create(['stadium_name' => '球場B']);
    }

    /** @return array{first_base_team_id: string, third_base_team_id: string, stadium_id: int, game_date: string, scheduled_start_time: string} */
    private function attributes(): array
    {
        return [
            'first_base_team_id' => self::FIRST_TEAM_ID,
            'third_base_team_id' => self::THIRD_TEAM_ID,
            'stadium_id' => 1,
            'game_date' => '2026-10-10',
            'scheduled_start_time' => '18:00',
        ];
    }

    public function test_crud_and_validation(): void
    {
        $this->get(route('game-schedule.create'))->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('GameSchedule/Create')->has('teams', 3)->has('stadiums', 2));

        $this->post(route('game-schedule.store'), [
            ...$this->attributes(),
            'third_base_team_id' => self::FIRST_TEAM_ID,
        ])->assertSessionHasErrors('first_base_team_id');
        $this->assertDatabaseCount('game_schedules', 0);

        $this->post(route('game-schedule.store'), $this->attributes())
            ->assertRedirect(route('game-schedule.index'));
        $schedule = GameSchedule::query()->firstOrFail();
        $this->get(route('game-schedule.edit', $schedule->id))->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('GameSchedule/Edit')->where('schedule.id', $schedule->id));

        $this->put(route('game-schedule.update', $schedule->id), [
            ...$this->attributes(),
            'third_base_team_id' => self::OTHER_TEAM_ID,
            'scheduled_start_time' => '19:30',
        ])->assertRedirect(route('game-schedule.index'));
        $this->assertDatabaseHas('game_schedules', ['id' => $schedule->id, 'third_base_team_id' => self::OTHER_TEAM_ID]);

        $this->delete(route('game-schedule.destroy', $schedule->id))
            ->assertRedirect(route('game-schedule.index'));
        $this->assertDatabaseCount('game_schedules', 0);
        $this->get(route('game-schedule.edit', $schedule->id))->assertNotFound();
        $this->delete(route('game-schedule.destroy', $schedule->id))->assertNotFound();
    }

    public function test_filters_both_team_sides_and_only_returns_requested_page(): void
    {
        for ($i = 0; $i < 21; $i++) {
            GameSchedule::query()->create([
                ...$this->attributes(),
                'first_base_team_id' => $i === 0 ? self::OTHER_TEAM_ID : self::FIRST_TEAM_ID,
                'third_base_team_id' => $i === 0 ? self::FIRST_TEAM_ID : self::THIRD_TEAM_ID,
            ]);
        }
        GameSchedule::query()->create([
            ...$this->attributes(),
            'stadium_id' => 2,
            'game_date' => '2026-10-11',
            'scheduled_start_time' => '19:00',
        ]);

        $filters = [
            'game_dates' => ['2026-10-10'],
            'scheduled_start_times' => ['18:00'],
            'team_ids' => [self::FIRST_TEAM_ID],
            'stadium_ids' => [1],
        ];
        $this->get(route('game-schedule.index', $filters))->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('GameSchedule/Index')
                ->where('schedules.total', 21)->has('schedules.data', 20));
        $this->get(route('game-schedule.index', [...$filters, 'page' => 2]))->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('GameSchedule/Index')
                ->where('schedules.current_page', 2)->has('schedules.data', 1));

        $this->get(route('game-schedule.index', ['team_ids' => [self::OTHER_TEAM_ID]]))->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('GameSchedule/Index')
                ->where('schedules.total', 1)->has('schedules.data', 1));

        $this->get(route('game-schedule.index', [
            'game_dates' => ['2026-10-10', '2026-10-11'],
            'scheduled_start_times' => ['18:00', '19:00'],
            'stadium_ids' => [1, 2],
        ]))->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('GameSchedule/Index')
                ->where('schedules.total', 22)->has('schedules.data', 20));
    }
}
