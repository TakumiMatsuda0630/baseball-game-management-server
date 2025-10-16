<?php

declare(strict_types=1);

namespace Application\Http\Controllers\Admin;

use Application\Http\Controllers\Controller;
use Application\Domain\Stadium\Query\GetStadiumsQuery;
use Application\Domain\Stadium\Query\GetStadiumQuery;
use Application\Http\Request\Admin\Stadium\StoreStadiumRequest;
use Application\Http\Request\Admin\Stadium\UpdateStadiumRequest;
use Application\Domain\Stadium\UseCase\StoreStadiumInput;
use Application\Domain\Stadium\UseCase\StoreStadiumUseCase;
use Application\Domain\Stadium\UseCase\UpdateStadiumInput;
use Application\Domain\Stadium\UseCase\UpdateStadiumUseCase;
use Application\Domain\Stadium\UseCase\DeleteStadiumInput;
use Application\Domain\Stadium\UseCase\DeleteStadiumUseCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class StadiumController extends Controller
{
    public function __construct(
        private readonly GetStadiumsQuery $getStadiumsQuery,
        private readonly GetStadiumQuery $getStadiumQuery,
        private readonly StoreStadiumUseCase $storeStadiumUseCase,
        private readonly UpdateStadiumUseCase $updateStadiumUseCase,
        private readonly DeleteStadiumUseCase $deleteStadiumUseCase,
    )
    {
        
    }

    /**
     * 球場一覧画面の表示
     *
     * @return Response
     */
    public function index(): Response
    {
        // 球場一覧を取得
        $stadiums = $this->getStadiumsQuery->getStadiums();

        return inertia('Stadium/Index', [
            'stadiums' => $stadiums,
        ]);
    }

    /**
     * 球場登録画面の表示
     *
     * @return Response
     */
    public function create(): Response
    {
        // 球場一覧を取得
        $stadiums = $this->getStadiumsQuery->getStadiums();

        return inertia('Stadium/Create', []);
    }

    /**
     * 球場の登録
     *
     * @return RedirectResponse|Response
     */
    public function store(StoreStadiumRequest $request): RedirectResponse|Response
    {
        $input = new StoreStadiumInput(
            $request->stadiumName()
        );

        try {
            $this->storeStadiumUseCase->process($input);
        } catch (\Throwable $e) {
            // 登録画面に戻る
            return inertia('Stadium/Create', [
                'errors' => [
                    'message' => $e->getMessage(),
                ],
            ]);
        }

        return redirect()
            ->route('stadium.index')
            ->with('success', '球場の登録が完了しました。');
    }

    /**
     * 球場詳細画面の表示
     *
     * @return Response
     */
    public function edit(int $id): Response
    {
        // 球場一覧を取得
        $stadium = $this->getStadiumQuery->getStadiumById($id);

        return inertia('Stadium/Edit', [
            'stadium' => $stadium,
        ]);
    }

    /**
     * 球場の更新
     *
     * @return RedirectResponse|Response
     */
    public function update(UpdateStadiumRequest $request, int $id): RedirectResponse|Response
    {
        $input = new UpdateStadiumInput(
            $id,
            $request->stadiumName()
        );

        try {
            $this->updateStadiumUseCase->process($input);
        } catch (\Throwable $e) {
            // 登録画面に戻る
            return inertia('Stadium/Edit', [
                'errors' => [
                    'message' => $e->getMessage(),
                ],
            ]);
        }

        return redirect()
            ->route('stadium.index')
            ->with('success', '球場の更新が完了しました。');
    }

    /**
     * 球場の削除
     *
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $input = new DeleteStadiumInput($id);

        try {
            $this->deleteStadiumUseCase->process($input);
        } catch (\Throwable $e) {
            return redirect()
                ->route('stadium.index')
                ->with('error', '球場の削除に失敗しました。');
        }

        return redirect()
            ->route('stadium.index')
            ->with('success', '球場の削除が完了しました。');
    }
}
