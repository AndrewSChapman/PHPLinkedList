<?php

namespace ChapmanDigital\LinkedList\Exceptions;

class EndOfListException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('You have reached the end of the list', 0, null);
    }

}