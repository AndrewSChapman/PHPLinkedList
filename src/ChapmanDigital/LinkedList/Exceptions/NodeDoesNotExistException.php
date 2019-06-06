<?php

namespace ChapmanDigital\LinkedList\Exceptions;

class NodeDoesNotExistException extends \DomainException
{
    public function __construct(int $index)
    {
        parent::__construct("There is no node at index $index", 0, null);
    }
}