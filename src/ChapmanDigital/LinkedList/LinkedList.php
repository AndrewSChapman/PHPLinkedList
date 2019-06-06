<?php

namespace ChapmanDigital\LinkedList;

use ChapmanDigital\LinkedList\Exceptions\EmptyListException;
use ChapmanDigital\LinkedList\Exceptions\EndOfListException;
use ChapmanDigital\LinkedList\Exceptions\InvalidListPositionException;
use ChapmanDigital\LinkedList\Exceptions\NodeDoesNotExistException;
use ChapmanDigital\LinkedList\Node\NodeInterface;
use ChapmanDigital\LinkedList\Sort\LinkListSorterInterface;

class LinkedList
{
    /** @var NodeInterface|null  */
    private $head;

    /** @var NodeInterface|null  */
    private $tail;

    /** @var int  */
    private $nodeCount = 0;

    public function __construct()
    {
        $this->head = null;
        $this->tail = null;
    }

    /**
     * Appends a new node to the linked list.
     */
    public function append(NodeInterface $node)
    {
        if (!$this->tail) {
            $this->head = $node;
            $this->tail = $node;
            $this->nodeCount++;

            return;
        }


        $this->tail->setNextNode($node);
        $this->tail = $node;

        $this->nodeCount++;
    }

    /** Iterates over the list using a generator */
    public function iterate(): \Generator
    {
        /** @var NodeInterface|null $currentNode */
        $currentNode = $this->head;

        while ($currentNode != null) {
            try {
                yield $currentNode;
                $currentNode = $currentNode->getNextNode();
            } catch (EndOfListException $exception) {
                $currentNode = null;
            }
        }
    }

    /**
     * Returns the size of the linked list.
     */
    public function size(): int
    {
        return $this->nodeCount;
    }

    /**
     * Reverses the nodes in the linked list
     */
    public function reverse(): void
    {
        if (!$this->head) {
            return;
        }

        /** @var NodeInterface $oldFirstNode */
        $oldFirstNode = $this->head;

        /** @var NodeInterface|null $nextNode */
        $nextNode = $this->head;

        /** @var NodeInterface|null $currentNode */
        $currentNode = null;

        /** @var NodeInterface|null $previousNode */
        $previousNode = null;

        while ($nextNode != null) {
            try {
                $currentNode = $nextNode;
                $nextNode = $nextNode->getNextNode();

                if ($previousNode != null) {
                    $currentNode->setNextNode($previousNode);
                }

                $previousNode = $currentNode;

            } catch (EndOfListException $exception) {
                $currentNode->setNextNode($previousNode);

                // The top of the list is now the last node that was found
                $this->head = $currentNode;

                // The bottom of the list is now the old first node.
                $this->tail = $oldFirstNode;
                $oldFirstNode->clearNextNode();

                $nextNode = null;
            }
        }
    }

    /**
     * Removes a node at the given position.
     * @throws EmptyListException
     * @throws NodeDoesNotExistException
     */
    public function removeNodeAtPosition(int $x): NodeInterface
    {
        if (!$this->head) {
            throw new EmptyListException();
        }

        if (($x <= 0) || ($x > $this->size())) {
            throw new NodeDoesNotExistException($x);
        }

        // If we're removing the first node,
        // set the head to be the next node if there is one.
        // Otherwise reset the list.
        if ($x == 1) {
            $node = $this->head;

            try {
                $this->head = $node->getNextNode();
                $this->nodeCount--;
            } catch (EndOfListException $exception) {
                $this->reset();
            }

            return $node;
        }

        // Find the node that we want to remove
        $index = 0;

        /** @var NodeInterface|null $previousNode */
        $previousNode = null;

        /** @var NodeInterface $node */
        foreach($this->iterate() as $node) {
            $index++;

            // If this is the node we want, set the next node of the previous node
            // to be the next node of the current node.
            if ($x === $index) {
                try {
                    $previousNode->setNextNode($node->getNextNode());
                } catch (EndOfListException $exception) {
                    $previousNode->clearNextNode();
                    $this->tail = $previousNode;
                }

                $this->nodeCount--;

                return $node;
            }

            $previousNode = $node;
        }

        throw new NodeDoesNotExistException($x);
    }

    /**
     * Inserts a new node at position X
     * @throws InvalidListPositionException
     */
    public function insertNodeAtPosition(NodeInterface $insertNode, int $x): void
    {
        if ($x < 1) {
            throw new InvalidListPositionException($x);
        }

        if (($x > 1) && ($x > ($this->size() + 1))) {
            throw new InvalidListPositionException($x);
        }

        // Are we inserting at the front of the list?
        if ($x === 1) {
            if (!$this->head) {
                $this->head = $insertNode;
                $this->tail = $insertNode;
            } else {
                $insertNode->setNextNode($this->head);
                $this->head = $insertNode;
            }

            $this->nodeCount++;
            return;
        }

        // Are we inserting at the end of the list?
        if ($x === ($this->size() + 1)) {
            $this->tail->setNextNode($insertNode);
            $this->tail = $insertNode;
            $this->nodeCount++;

            return;
        }


        // Find the node that we want to insert in front of
        $index = 0;

        /** @var NodeInterface|null $previousNode */
        $previousNode = null;

        /** @var NodeInterface $node */
        foreach($this->iterate() as $node) {
            $index++;

            // If this is the node we want, set the next node of the insert node
            // to be the current node, and the next node of the previous node to be the
            // insert node.
            if ($x === $index) {
                $insertNode->setNextNode($node);
                $previousNode->setNextNode($insertNode);
                $this->nodeCount++;

                return;
            }

            $previousNode = $node;
        }
    }

    /**
     * Swaps the position of two nodes
     * @throws EmptyListException
     * @throws NodeDoesNotExistException
     */
    public function swap(int $aPos, int $bPos): void
    {
        if (!$this->head) {
            throw new EmptyListException();
        }

        // Swapping a node for itself means nothing to do.
        if ($aPos === $bPos) {
            return;
        }

        // A and B positions should fit within the list size.
        if (($aPos <= 0) || ($aPos > $this->size())) {
            throw new NodeDoesNotExistException($aPos);
        }

        if (($bPos <= 0) || ($bPos > $this->size())) {
            throw new NodeDoesNotExistException($bPos);
        }

        if ($bPos < $aPos) {
            $temp = $bPos;
            $bPos = $aPos;
            $aPos = $temp;
        }

        $bNode = $this->removeNodeAtPosition($bPos);
        $aNode = $this->removeNodeAtPosition($aPos);

        $this->insertNodeAtPosition($bNode, $aPos);
        $this->insertNodeAtPosition($aNode, $bPos);
    }

    /**
     * Sorts the list using the sorter interface.
     * Allows us to implement any sorting algorithm we want
     * and have consistent usage.
     */
    public function sort(LinkListSorterInterface $sorter): void
    {
        $sorter->sort($this);
    }

    /**
     * Resets the list.
     */
    public function reset(): void {
        $this->head = null;
        $this->tail = null;
        $this->nodeCount = 0;
    }
}