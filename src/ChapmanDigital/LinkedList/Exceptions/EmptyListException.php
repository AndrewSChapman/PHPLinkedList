<?php

namespace ChapmanDigital\LinkedList\Exceptions;

class EmptyListException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The LinkedList is currently empty!', 0, null);
    }

}