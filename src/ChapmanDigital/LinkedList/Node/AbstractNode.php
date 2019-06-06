<?php

namespace ChapmanDigital\LinkedList\Node;

use ChapmanDigital\LinkedList\Exceptions\EndOfListException;
use Ramsey\Uuid\Uuid;

/**
 * Provides the core Node functionality for the LinkedList.
 */
abstract class AbstractNode
{
    /** @var Uuid */
    private $id;

    /** @var NodeInterface|null */
    private $nextNode;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function setNextNode(NodeInterface $nextNode): void
    {
        $this->nextNode = $nextNode;
    }

    public function getNextNode(): NodeInterface
    {
        if (!$this->nextNode) {
            throw new EndOfListException();
        }

        return $this->nextNode;
    }

    public function clearNextNode(): void
    {
        $this->nextNode = null;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}