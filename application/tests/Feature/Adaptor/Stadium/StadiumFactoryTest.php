<?php

declare(strict_types=1);

namespace Tests\Feature\Adaptor\Stadium;

use Application\Domain\Stadium\StadiumFactoryInterface;
use Application\Models\Stadium as StadiumModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StadiumFactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 球場情報を生成できること.
     */
    public function testCreateStadium(): void
    {
        $stadiumName = 'testName';
        /** @var int $maxId */
        $maxId = StadiumModel::max('id');
        $expedtedStadiumId = $maxId + 1;

        // StadiumFactoryのインスタンスを生成
        $stadiumFactory = app(StadiumFactoryInterface::class);

        // テスト対象メソッドの実行
        $stadium = $stadiumFactory->createStadium($stadiumName);

        // 実行結果のアサーション
        $this->assertSame($expedtedStadiumId, $stadium->id()->toInt());
        $this->assertSame($stadiumName, (string) $stadium->name());
    }
}
