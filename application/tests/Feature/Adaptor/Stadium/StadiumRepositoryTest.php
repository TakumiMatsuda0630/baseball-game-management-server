<?php

declare(strict_types=1);

namespace Tests\Feature\Adaptor\Stadium;

use Application\Domain\Stadium\Entity\Stadium;
use Application\Domain\Stadium\StadiumRepositoryInterface;
use Application\Domain\Stadium\ValueObject\StadiumId;
use Application\Domain\Stadium\ValueObject\StadiumName;
use Application\Models\Stadium as StadiumModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StadiumRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * stadiumテーブルからデータを正しく取得できること
     */
    public function testGetStadiumById(): void
    {
        // テストデータを事前に登録
        $id = 1;
        $stadiumName = 'testName';
        StadiumModel::query()
            ->insert([
                'id' => $id,
                'stadium_name' => $stadiumName,
            ]);

        // StadiumRepositoryのインスタンスを生成
        $stadiumRepository = app(StadiumRepositoryInterface::class);

        // テスト対象メソッドの実行
        $stadium = $stadiumRepository->getStadiumById(new StadiumId($id));

        // 実行結果のアサーション
        $this->assertSame($id, $stadium?->id()->toInt());
        $this->assertSame($stadiumName, (string) $stadium->name());
    }

    /**
     * 存在しないIDを指定するとnullが返却されること.
     */
    public function testGetStadiumByNotExistsId(): void
    {
        // テストデータを事前に登録
        $id = 1;
        $stadiumName = 'testName';
        StadiumModel::query()
            ->insert([
                'id' => $id,
                'stadium_name' => $stadiumName,
            ]);

        // StadiumRepositoryのインスタンスを生成
        $stadiumRepository = app(StadiumRepositoryInterface::class);

        // テスト対象メソッドの実行
        $stadium = $stadiumRepository->getStadiumById(new StadiumId(2));

        // 実行結果のアサーション
        $this->assertNull($stadium);
    }

    /**
     * 球場情報を登録できること
     */
    public function testCreateStadium(): void
    {
        // StadiumRepositoryのインスタンスを生成
        $stadiumRepository = app(StadiumRepositoryInterface::class);

        // 新規登録用の球場情報を作成
        $newStadiumId = 1;
        $newStadiumName = 'testName';
        $newStadium = new Stadium(
            new StadiumId($newStadiumId),
            new StadiumName($newStadiumName)
        );

        // テスト対象メソッドの実行
        $stadiumRepository->save($newStadium);

        // 登録済データを取得
        $registeredStadium = StadiumModel::query()
            ->find($newStadiumId);

        $this->assertSame($newStadiumId, $registeredStadium?->id);
        $this->assertSame($newStadiumName, $registeredStadium->stadium_name);
    }

    /**
     * 球場情報を登録/更新できること
     */
    public function testUpdateStadium(): void
    {
        // 更新用の球場情報を登録
        $id = 1;
        $stadiumName = 'testName1_before';
        StadiumModel::query()
            ->insert([
                'id' => $id,
                'stadium_name' => $stadiumName,
            ]);

        // StadiumRepositoryのインスタンスを生成
        $stadiumRepository = app(StadiumRepositoryInterface::class);

        // 新規登録用の球場情報を作成
        $updatedStadiumName = 'testName1_after';
        $newStadium = new Stadium(
            new StadiumId($id),
            new StadiumName($updatedStadiumName)
        );

        // 球場情報更新
        $stadiumRepository->save($newStadium);

        // 更新済データを取得
        $updatedStadium = StadiumModel::query()
            ->find($id);

        //
        $this->assertSame($updatedStadiumName, $updatedStadium?->stadium_name);
    }

    /**
     * 球場情報をs削除できること
     */
    public function testDeleteStadium(): void
    {
        // 削除用の球場情報を登録
        $id = 1;
        $stadiumName = 'testName1';
        StadiumModel::query()
            ->insert([
                'id' => $id,
                'stadium_name' => $stadiumName,
            ]);

        // StadiumRepositoryのインスタンスを生成
        $stadiumRepository = app(StadiumRepositoryInterface::class);

        $stadium = new Stadium(
            new StadiumId($id),
            new StadiumName($stadiumName)
        );

        // 球場情報削除
        $stadiumRepository->delete($stadium);

        // 更新済データを取得
        $deletedStadium = StadiumModel::query()
            ->find($id);

        //
        $this->assertNull($deletedStadium);
    }
}
