<?php

namespace ChapmanDigital\LinkedList\Exceptions;

class InvalidListPositionException extends \DomainException
{
    public function __construct(int $position)
    {
        parent::__construct("The position $position is invalid in the LinkedList!", 0, null);
    }

}