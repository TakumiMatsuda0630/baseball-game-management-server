<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Team\UseCase;

use Application\Domain\Team\UseCase\DeleteTeamInput;
use Application\Domain\Team\UseCase\StoreTeamInput;
use Application\Domain\Team\UseCase\UpdateTeamInput;
use PHPUnit\Framework\TestCase;

class TeamInputTest extends TestCase
{
    public function test_store_input_keeps_name(): void
    {
        $this->assertSame('チームA', (new StoreTeamInput('チームA'))->getName());
    }

    public function test_update_input_keeps_id_and_name(): void
    {
        $id = '550e8400-e29b-41d4-a716-446655440001';
        $input = new UpdateTeamInput($id, 'チームA');

        $this->assertSame($id, $input->getId());
        $this->assertSame('チームA', $input->getName());
    }

    public function test_delete_input_keeps_id(): void
    {
        $id = '550e8400-e29b-41d4-a716-446655440001';

        $this->assertSame($id, (new DeleteTeamInput($id))->getId());
    }
}
