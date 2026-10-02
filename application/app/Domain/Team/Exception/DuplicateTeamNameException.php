<?php

declare(strict_types=1);

namespace Application\Domain\Team\Exception;

use DomainException;
use Throwable;

class DuplicateTeamNameException extends DomainException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('同じ名前のチームは登録できません。', 0, $previous);
    }
}
