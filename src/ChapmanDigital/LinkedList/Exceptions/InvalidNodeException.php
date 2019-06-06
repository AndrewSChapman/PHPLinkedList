<?php

namespace ChapmanDigital\LinkedList\Exceptions;

class InvalidNodeException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The passed node is of an invalid type', 0, null);
    }
}