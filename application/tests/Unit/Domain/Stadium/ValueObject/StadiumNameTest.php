<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Stadium\ValueObject;

use InvalidArgumentException;
use Application\Domain\Stadium\ValueObject\StadiumName;
use Tests\TestCase;

class StadiumNameTest extends TestCase
{
    /**
     * インスタンスを生成し、正しく値を保持すること
     */
    public function testStadiumName(): void
    {;
        $stadiumNameStr = 'test stadium name';
        $stadiumName = new StadiumName($stadiumNameStr);
        $this->assertEquals($stadiumNameStr, (string)$stadiumName);
    }

    /**
     * 空文字を設定した場合、InvalidArgumentExceptionが発生すること
     */
    public function testStadiumNameCannotBeEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new StadiumName('');
    }

    /**
     * 256文字以上を設定した場合、InvalidArgumentExceptionが発生すること
     */
    public function testStadiumNameMustBeBetween1And255Characters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new StadiumName(str_repeat('a', 256));
    }
}