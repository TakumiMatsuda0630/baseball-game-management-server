<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Admin;

use Application\Models\Team as TeamModel;
use Application\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase;

    private const TEAM_ID = '550e8400-e29b-41d4-a716-446655440001';

    private const ANOTHER_TEAM_ID = '550e8400-e29b-41d4-a716-446655440002';

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('app.key', 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=');
        $this->withoutVite();
        $this->actingAs(User::factory()->create());
    }

    public function test_index_displays_teams(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        $this->get(route('team.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Team/Index')
                ->has('teams', 1)
                ->where('teams.0.team_name', 'チームA'));
    }

    public function test_create_displays_form(): void
    {
        $this->get(route('team.create'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Team/Create'));
    }

    public function test_store_creates_team(): void
    {
        $this->post(route('team.store'), ['team_name' => 'チームA'])
            ->assertRedirect(route('team.index'))
            ->assertSessionHas('success', 'チームの登録が完了しました。');

        $this->assertDatabaseHas('teams', ['team_name' => 'チームA']);
    }

    public function test_store_rejects_duplicate_name(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        $this->from(route('team.create'))
            ->post(route('team.store'), ['team_name' => 'チームA'])
            ->assertRedirect(route('team.create'))
            ->assertSessionHasErrors('team_name');

        $this->assertDatabaseCount('teams', 1);
    }

    public function test_store_validates_required_and_maximum_length(): void
    {
        $this->post(route('team.store'), ['team_name' => ''])
            ->assertSessionHasErrors('team_name');
        $this->post(route('team.store'), ['team_name' => str_repeat('あ', 101)])
            ->assertSessionHasErrors('team_name');
    }

    public function test_edit_displays_team_and_missing_team_returns_not_found(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        $this->get(route('team.edit', ['id' => self::TEAM_ID]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Team/Edit')
                ->where('team.team_name', 'チームA'));
        $this->get(route('team.edit', ['id' => self::ANOTHER_TEAM_ID]))->assertNotFound();
    }

    public function test_update_changes_team_name_and_allows_current_name(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => '変更前']);

        $this->put(route('team.update', ['id' => self::TEAM_ID]), ['team_name' => '変更後'])
            ->assertRedirect(route('team.index'));
        $this->put(route('team.update', ['id' => self::TEAM_ID]), ['team_name' => '変更後'])
            ->assertRedirect(route('team.index'));

        $this->assertDatabaseHas('teams', ['id' => self::TEAM_ID, 'team_name' => '変更後']);
    }

    public function test_update_rejects_another_teams_name(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);
        TeamModel::query()->create(['id' => self::ANOTHER_TEAM_ID, 'team_name' => 'チームB']);

        $this->from(route('team.edit', ['id' => self::ANOTHER_TEAM_ID]))
            ->put(route('team.update', ['id' => self::ANOTHER_TEAM_ID]), ['team_name' => 'チームA'])
            ->assertRedirect(route('team.edit', ['id' => self::ANOTHER_TEAM_ID]))
            ->assertSessionHasErrors('team_name');

        $this->assertDatabaseHas('teams', ['id' => self::ANOTHER_TEAM_ID, 'team_name' => 'チームB']);
    }

    public function test_destroy_deletes_team(): void
    {
        TeamModel::query()->create(['id' => self::TEAM_ID, 'team_name' => 'チームA']);

        $this->delete(route('team.destroy', ['id' => self::TEAM_ID]))
            ->assertRedirect(route('team.index'))
            ->assertSessionHas('success', 'チームの削除が完了しました。');

        $this->assertDatabaseMissing('teams', ['id' => self::TEAM_ID]);
    }

    public function test_update_and_destroy_return_not_found_for_missing_team(): void
    {
        $this->put(route('team.update', ['id' => self::TEAM_ID]), ['team_name' => '変更後'])
            ->assertNotFound();

        $this->delete(route('team.destroy', ['id' => self::TEAM_ID]))
            ->assertNotFound();
    }

    public function test_routes_reject_malformed_team_id(): void
    {
        $this->get('/admin/team/edit/not-a-uuid')->assertNotFound();
        $this->put('/admin/team/update/not-a-uuid', ['team_name' => '変更後'])->assertNotFound();
        $this->delete('/admin/team/delete/not-a-uuid')->assertNotFound();
    }
}
