<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Stadium\Entity;

use Application\Domain\Stadium\Entity\Stadium;
use Application\Domain\Stadium\ValueObject\StadiumId;
use Application\Domain\Stadium\ValueObject\StadiumName;
use PHPUnit\Framework\TestCase;

class StadiumTest extends TestCase
{
    /**
     * インスタンスを生成し、正しく値を保持すること.
     */
    public function testStadiumCreation(): void
    {
        $id = new StadiumId(12345678901);
        $name = new StadiumName('Test Stadium');

        $stadium = new Stadium($id, $name);

        $this->assertInstanceOf(Stadium::class, $stadium);
        $this->assertEquals($id, $stadium->id());
        $this->assertEquals($name, $stadium->name());
    }

    /**
     * toArrayメソッドが正しく動作すること.
     */
    public function testToArray(): void
    {
        $id = new StadiumId(12345678901);
        $name = new StadiumName('Test Stadium');

        $stadium = new Stadium($id, $name);

        $expectedArray = [
            'id' => (string)$id,
            'name' => (string)$name,
        ];

        $this->assertEquals($expectedArray, $stadium->toArray());
    }
}