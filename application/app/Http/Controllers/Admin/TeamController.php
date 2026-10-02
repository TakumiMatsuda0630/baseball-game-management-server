<?php

declare(strict_types=1);

namespace Application\Http\Controllers\Admin;

use Application\Domain\Team\Exception\DuplicateTeamNameException;
use Application\Domain\Team\Exception\TeamNotFoundException;
use Application\Domain\Team\Query\GetTeamQuery;
use Application\Domain\Team\Query\GetTeamsQuery;
use Application\Domain\Team\UseCase\DeleteTeamInput;
use Application\Domain\Team\UseCase\DeleteTeamUseCase;
use Application\Domain\Team\UseCase\StoreTeamInput;
use Application\Domain\Team\UseCase\StoreTeamUseCase;
use Application\Domain\Team\UseCase\UpdateTeamInput;
use Application\Domain\Team\UseCase\UpdateTeamUseCase;
use Application\Http\Controllers\Controller;
use Application\Http\Request\Admin\Team\StoreTeamRequest;
use Application\Http\Request\Admin\Team\UpdateTeamRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class TeamController extends Controller
{
    public function __construct(
        private readonly GetTeamsQuery $getTeamsQuery,
        private readonly GetTeamQuery $getTeamQuery,
        private readonly StoreTeamUseCase $storeTeamUseCase,
        private readonly UpdateTeamUseCase $updateTeamUseCase,
        private readonly DeleteTeamUseCase $deleteTeamUseCase,
    ) {
    }

    /**
     * チーム一覧画面を表示する。
     */
    public function index(): Response|ResponseFactory
    {
        return inertia('Team/Index', [
            'teams' => $this->getTeamsQuery->getTeams(),
        ]);
    }

    /**
     * チーム登録画面を表示する。
     */
    public function create(): Response|ResponseFactory
    {
        return inertia('Team/Create');
    }

    /**
     * 入力されたチームを登録する。
     */
    public function store(StoreTeamRequest $request): RedirectResponse
    {
        try {
            $this->storeTeamUseCase->process(new StoreTeamInput($request->teamName()));
        } catch (DuplicateTeamNameException $exception) {
            return back()->withErrors(['team_name' => $exception->getMessage()]);
        }

        return redirect()
            ->route('team.index')
            ->with('success', 'チームの登録が完了しました。');
    }

    /**
     * 指定したチームの編集画面を表示する。
     */
    public function edit(string $id): Response|ResponseFactory
    {
        $team = $this->getTeamQuery->getTeamById($id);
        abort_if($team === null, 404);

        return inertia('Team/Edit', ['team' => $team]);
    }

    /**
     * 指定したチームの名称を更新する。
     */
    public function update(UpdateTeamRequest $request, string $id): RedirectResponse
    {
        try {
            $this->updateTeamUseCase->process(new UpdateTeamInput($id, $request->teamName()));
        } catch (DuplicateTeamNameException $exception) {
            return back()->withErrors(['team_name' => $exception->getMessage()]);
        } catch (TeamNotFoundException) {
            abort(404);
        }

        return redirect()
            ->route('team.index')
            ->with('success', 'チームの更新が完了しました。');
    }

    /**
     * 指定したチームを削除する。
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->deleteTeamUseCase->process(new DeleteTeamInput($id));
        } catch (TeamNotFoundException) {
            abort(404);
        }

        return redirect()
            ->route('team.index')
            ->with('success', 'チームの削除が完了しました。');
    }
}
