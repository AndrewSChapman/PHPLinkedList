<?php

namespace ChapmanDigital\LinkedList\Sort;

use ChapmanDigital\LinkedList\LinkedList;
use ChapmanDigital\LinkedList\Node\NodeInterface;

class LinearSorter implements LinkListSorterInterface
{
    public function sort(LinkedList $list)
    {
        $nodeWasSwapped = true;

        while ($nodeWasSwapped) {
            $nodeWasSwapped = false;
            $lastNode = null;
            $nodeIndex = 1;

            /** @var NodeInterface $node */
            foreach ($list->iterate() as $node) {
                if ($lastNode !== null) {
                    if ($node->compare($lastNode) > 0) {
                        $list->swap($nodeIndex - 1, $nodeIndex);
                        $nodeWasSwapped = true;
                        break;
                    }
                }

                $lastNode = $node;
                $nodeIndex++;
            }
        }
    }
}