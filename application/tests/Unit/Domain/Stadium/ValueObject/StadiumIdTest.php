<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Stadium\ValueObject;

use Application\Domain\Stadium\ValueObject\StadiumId;
use InvalidArgumentException;
use Tests\TestCase;

class StadiumIdTest extends TestCase
{

    /**
     * インスタンスを生成し、正常に値を保持すること
     */
    public function testValidStadiumId(): void
    {
        $id        = 12345678901;
        $stadiumId = new StadiumId($id);

        $this->assertSame($id, $stadiumId->toInt());
        $this->assertSame((string)$id, (string)$stadiumId);
    }

    /**
     * 無効なスタジアムIDを渡した場合、例外がスローされること
     */
    public function testAnotherInvalidStadiumIdThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new StadiumId(123456789012);
    }
}
