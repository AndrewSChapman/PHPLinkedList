<?php

namespace ChapmanDigital\LinkedList\Node;

use Ramsey\Uuid\Uuid;

interface NodeInterface
{
    public function setNextNode(NodeInterface $nextNode): void;
    public function getNextNode(): NodeInterface;
    public function clearNextNode(): void;
    public function compare(NodeInterface $node): int;
    public function getId(): Uuid;
}