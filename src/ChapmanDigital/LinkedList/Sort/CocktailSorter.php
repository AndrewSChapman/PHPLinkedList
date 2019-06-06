<?php

namespace ChapmanDigital\LinkedList\Sort;

use ChapmanDigital\LinkedList\LinkedList;
use ChapmanDigital\LinkedList\Node\NodeInterface;

/**
 * Class CocktailSorter
 * Implements a "Cocktail" Bubble sort (sorting from both ends).
 */
class CocktailSorter implements LinkListSorterInterface
{
    public function sort(LinkedList $list)
    {
        $nodeCount = $list->size();

        if ($nodeCount === 0) {
            return;
        }

        $nodes = [];
        foreach ($list->iterate() as $node) {
            $nodes[] = $node;
        }

        $nodeWasSwapped = true;

        while ($nodeWasSwapped) {
            $nodeWasSwapped = false;
            $lastNode = null;

            // Iterate forwards, swapping as we go.
            for ($nodeIndex = 0; $nodeIndex < $nodeCount; $nodeIndex++) {
                $node = $nodes[$nodeIndex];

                if ($lastNode !== null) {
                    if ($node->compare($lastNode) > 0) {
                        $nodes[$nodeIndex - 1] = $node;
                        $nodes[$nodeIndex] = $lastNode;
                        $nodeWasSwapped = true;
                    } else {
                        $lastNode = $node;
                    }
                } else {
                    $lastNode = $node;
                }
            }

            // Iterate backwards, swapping as we go.
            if ($nodeWasSwapped) {
                $nodeWasSwapped = false;

                // Iterate backwards, swapping as we go.
                for ($nodeIndex = $nodeCount - 1; $nodeIndex >= 0; $nodeIndex--) {
                    $node = $nodes[$nodeIndex];

                    if ($lastNode !== null) {
                        if ($lastNode->compare($node) > 0) {
                            $nodes[$nodeIndex + 1] = $node;
                            $nodes[$nodeIndex] = $lastNode;
                            $nodeWasSwapped = true;
                        } else {
                            $lastNode = $node;
                        }
                    } else {
                        $lastNode = $node;
                    }
                }
            }
        }

        // Rebuild the linked list in the sorted order
        $list->reset();

        /** @var NodeInterface $node */
        foreach ($nodes as $node) {
            $node->clearNextNode();
            $list->append($node);
        }
    }
}