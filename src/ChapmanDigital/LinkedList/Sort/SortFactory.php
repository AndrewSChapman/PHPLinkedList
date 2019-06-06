<?php

namespace ChapmanDigital\LinkedList\Sort;

class SortFactory
{
    public function getSorter(SortMethod $method): LinkListSorterInterface
    {
        switch ($method) {
            case SortMethod::COCKTAIL:
                return new CocktailSorter();
            case SortMethod::LINEAR:
                return new LinearSorter();
            default:
                throw new \DomainException('Unhandled sort algorithm: ' . $method);
        }
    }
}