<?php

namespace ChapmanDigital\LinkedList\Node;

use ChapmanDigital\LinkedList\Exceptions\InvalidNodeException;

final class BasicNode extends AbstractNode implements NodeInterface
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function compare(NodeInterface $node): int
    {
        if (!$node instanceof BasicNode) {
            throw new InvalidNodeException();
        }

        $thisName = strtoupper($this->getName());
        $compareName = strtoupper($node->getName());

        if ($compareName === $thisName) {
            return 0;
        } else if($compareName > $thisName) {
            return 1;
        } else {
            return - 1;
        }
    }
}