<?php

namespace ChapmanDigital\LinkedList\Sort;

use ChapmanDigital\LinkedList\LinkedList;

interface LinkListSorterInterface
{
    public function sort(LinkedList $list);
}