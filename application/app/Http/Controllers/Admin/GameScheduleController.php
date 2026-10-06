<?php

declare(strict_types=1);

namespace Application\Http\Controllers\Admin;

use Application\Domain\GameSchedule\Query\GetGameSchedulesQuery;
use Application\Domain\GameSchedule\UseCase\DeleteGameScheduleUseCase;
use Application\Domain\GameSchedule\UseCase\StoreGameScheduleUseCase;
use Application\Domain\GameSchedule\UseCase\UpdateGameScheduleUseCase;
use Application\Http\Controllers\Controller;
use Application\Http\Request\Admin\GameSchedule\SaveGameScheduleRequest;
use Application\Http\Request\Admin\GameSchedule\SearchGameSchedulesRequest;
use Application\Models\Stadium;
use Application\Models\Team;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class GameScheduleController extends Controller
{
    public function __construct(
        private readonly GetGameSchedulesQuery $query,
        private readonly StoreGameScheduleUseCase $store,
        private readonly UpdateGameScheduleUseCase $update,
        private readonly DeleteGameScheduleUseCase $delete,
    ) {
    }

    public function index(SearchGameSchedulesRequest $request): Response|ResponseFactory
    {
        $filters = $request->filters();

        return inertia('GameSchedule/Index', [
            'schedules' => $this->query->paginate($filters),
            'filters' => $filters,
            ...$this->options(),
        ]);
    }

    public function create(): Response|ResponseFactory
    {
        return inertia('GameSchedule/Create', $this->options());
    }

    public function store(SaveGameScheduleRequest $request): RedirectResponse
    {
        $this->store->process($request->attributes());

        return redirect()->route('game-schedule.index')->with('success', '試合予定を登録しました。');
    }

    public function edit(int $id): Response|ResponseFactory
    {
        return inertia('GameSchedule/Edit', [
            'schedule' => $this->query->find($id) ?? abort(404),
            ...$this->options(),
        ]);
    }

    public function update(SaveGameScheduleRequest $request, int $id): RedirectResponse
    {
        $this->update->process($id, $request->attributes());

        return redirect()->route('game-schedule.index')->with('success', '試合予定を更新しました。');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->delete->process($id);

        return redirect()->route('game-schedule.index')->with('success', '試合予定を削除しました。');
    }

    /** @return array{teams: mixed, stadiums: mixed} */
    private function options(): array
    {
        return [
            'teams' => Team::query()->select('id', 'team_name')->orderBy('team_name')->get(),
            'stadiums' => Stadium::query()->select('id', 'stadium_name')->orderBy('stadium_name')->get(),
        ];
    }
}
