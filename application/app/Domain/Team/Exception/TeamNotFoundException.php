<?php

declare(strict_types=1);

namespace Application\Domain\Team\Exception;

use DomainException;

class TeamNotFoundException extends DomainException
{
    public function __construct()
    {
        parent::__construct('指定されたチームが見つかりません。');
    }
}
