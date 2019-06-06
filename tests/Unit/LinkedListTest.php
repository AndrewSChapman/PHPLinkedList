<?php

namespace ChapmanDigital\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ChapmanDigital\LinkedList\Exceptions\EmptyListException;
use ChapmanDigital\LinkedList\Exceptions\InvalidListPositionException;
use ChapmanDigital\LinkedList\LinkedList;
use ChapmanDigital\LinkedList\Node\BasicNode;
use ChapmanDigital\LinkedList\Exceptions\NodeDoesNotExistException;
use ChapmanDigital\LinkedList\Sort\SortFactory;
use ChapmanDigital\LinkedList\Sort\SortMethod;

class LinkedListTest extends TestCase
{
    public function testLinkedListCanAddAndIterateNodes(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $this->assertEquals(count($people), $linkedList->size());

        $index = 0;

        /** @var BasicNode $node */
        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index], $node->getName());
            $index++;
        }
    }

    public function testLinkedListCanReverseItself(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->reverse();

        $people = array_reverse($people);

        $index = 0;

        /** @var BasicNode $node */
        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index], $node->getName());
            $index++;
        }
    }

    public function testLinkedListWillThrowExceptionWhenListIsEmpty(): void
    {
        $this->expectException(EmptyListException::class);

        $linkedList = new LinkedList();
        $linkedList->swap(1, 2);
    }

    public function testLinkedListSwapWillThrowExceptionWhenAPositionLessThanMinimum(): void
    {
        $this->expectException(NodeDoesNotExistException::class);

        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->swap(0, 3);
    }

    public function testLinkedListSwapWillThrowExceptionWhenBPositionLessThanMinimum(): void
    {
        $this->expectException(NodeDoesNotExistException::class);

        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->swap(1, 0);
    }

    public function testLinkedListSwapWillThrowExceptionWhenAPositionGreaterThanMaximum(): void
    {
        $this->expectException(NodeDoesNotExistException::class);

        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->swap(5, 3);
    }

    public function testLinkedListSwapWillThrowExceptionWhenBPositionGreaterThanMaximum(): void
    {
        $this->expectException(NodeDoesNotExistException::class);

        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->swap(3, 5);
    }

    public function testLinkedListRemoveNodeWillThrowExceptionIfListEmpty(): void
    {
        $this->expectException(EmptyListException::class);
        $linkedList = new LinkedList();
        $linkedList->removeNodeAtPosition(1);
    }

    public function testLinkedListRemoveNodeWillThrowExceptionIfPositionInvalid(): void
    {
        $this->expectException(NodeDoesNotExistException::class);

        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->removeNodeAtPosition(0);
    }

    public function testLinkedListRemoveNodeWillThrowExceptionIfPositionInvalid2(): void
    {
        $this->expectException(NodeDoesNotExistException::class);

        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->removeNodeAtPosition(5);
    }

    public function testLinkedListWillRemoveFirstNodeCorrectly(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        /** @var BasicNode $removedNode */
        $removedNode = $linkedList->removeNodeAtPosition(1);
        $this->assertEquals(3, $linkedList->size());
        $this->assertEquals($people[0], $removedNode->getName());

        array_shift($people);

        $index = 0;

        /** @var BasicNode $node */
        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index], $node->getName());
            $index++;
        }
    }

    public function testLinkedListWillRemoveLastNodeCorrectly(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        /** @var BasicNode $removedNode */
        $removedNode = $linkedList->removeNodeAtPosition(4);
        $this->assertEquals(3, $linkedList->size());
        $this->assertEquals($people[3], $removedNode->getName());

        array_pop($people);

        $index = 0;

        /** @var BasicNode $node */
        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index], $node->getName());
            $index++;
        }
    }

    public function testLinkedListWillRemoveSecondNodeCorrectly(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        /** @var BasicNode $removedNode */
        $removedNode = $linkedList->removeNodeAtPosition(2);
        $this->assertEquals(3, $linkedList->size());
        $this->assertEquals($people[1], $removedNode->getName());

        $people = [
            'Andy Chapman',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $index = 0;

        /** @var BasicNode $node */
        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index], $node->getName());
            $index++;
        }
    }

    public function testInsertNodeWillThrowExceptionIfPositionInvalid1(): void
    {
        $this->expectException(InvalidListPositionException::class);

        $linkedList = new LinkedList();

        $node = new BasicNode('Banana');
        $linkedList->insertNodeAtPosition($node,0);
    }

    public function testInsertNodeWillThrowExceptionIfPositionInvalid2(): void
    {
        $this->expectException(InvalidListPositionException::class);

        $linkedList = new LinkedList();

        $node = new BasicNode('Banana');
        $linkedList->insertNodeAtPosition($node,2);
    }

    public function testInsertNodeWillInsertCorrectlyAtPosition1IfListEmpty(): void
    {
        $linkedList = new LinkedList();

        $node = new BasicNode('Andy Chapman');
        $linkedList->insertNodeAtPosition($node,1);

        $this->assertEquals(1, $linkedList->size());

        $people = [
            'Andy Chapman',
        ];

        $index = 0;

        /** @var BasicNode $node */
        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index], $node->getName());
            $index++;
        }
    }

    public function testInsertNodeWillInsertCorrectlyAtPosition1IfListNotEmpty(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $node = new BasicNode('Laura');
        $linkedList->insertNodeAtPosition($node,1);

        $this->assertEquals(5, $linkedList->size());

        array_unshift($people, 'Laura');

        $index = 0;

        /** @var BasicNode $node */
        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index], $node->getName());
            $index++;
        }
    }

    public function testInsertNodeWillInsertCorrectlyAtEnd(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $node = new BasicNode('Laura');
        $linkedList->insertNodeAtPosition($node,5);

        $this->assertEquals(5, $linkedList->size());
        $people[] = 'Laura';

        $index = 0;

        /** @var BasicNode $node */
        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index], $node->getName());
            $index++;
        }
    }

    public function testInsertNodeWillInsertCorrectlyAtPosition2(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $node = new BasicNode('Laura');
        $linkedList->insertNodeAtPosition($node,2);
        $this->assertEquals(5, $linkedList->size());

        $people = array_merge(array_slice($people, 0, 1),
            ['Laura'],
            array_splice($people, 1)
        );

        $index = 0;

        /** @var BasicNode $node */
        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index], $node->getName());
            $index++;
        }
    }

    public function testLinkedListOfSize2SwapWillSwapCorrectly(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->swap(1, 2);

        $peopleSwapped = [
            'James Dobb',
            'Andy Chapman',
        ];

        $index = 0;

        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($peopleSwapped[$index++], $node->getName());
        }
    }

    public function testLinkedListOfSize3SwapWillSwapCorrectlyAtStart(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Alex',
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->swap(1, 2);

        $peopleSwapped = [
            'James Dobb',
            'Andy Chapman',
            'Alex',
        ];

        $index = 0;

        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($peopleSwapped[$index++], $node->getName());
        }
    }

    public function testLinkedListOfSize3SwapWillSwapCorrectlyAtEnd(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Alex',
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->swap(2, 3);

        $peopleSwapped = [
            'Andy Chapman',
            'Alex',
            'James Dobb',
        ];

        $index = 0;

        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($peopleSwapped[$index++], $node->getName());
        }
    }

    public function testLinkedListOfSize4SwapWillSwapCorrectlyInMiddle(): void
    {
        $people = [
            'Andy Chapman',
            'James Dobb',
            'Paul Hunt',
            'Alexander Karston'
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $linkedList->swap(2, 3);

        $peopleSwapped = [
            'Andy Chapman',
            'Paul Hunt',
            'James Dobb',
            'Alexander Karston'
        ];

        $index = 0;

        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($peopleSwapped[$index++], $node->getName());
        }
    }

    public function testLinkedListWillLinearSort(): void
    {
        $people = [
            'James Dobbington',
            'Andy Chapman',
            'Paul Hunter',
            'Alexander Karman',
            'Kelly Karington',
            'Zap Zappy',
            'Georgina George',
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $sortFactory = new SortFactory();
        $linkedList->sort($sortFactory->getSorter(new SortMethod(SortMethod::LINEAR)));

        $index = 0;
        sort($people);

        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index++], $node->getName());
        }
    }

    public function testLinkedListWillCocktailSort(): void
    {
        $people = [
            'James Dobbington',
            'Andy Chapman',
            'Paul Hunter',
            'Alexander Karman',
            'Kelly Karington',
            'Zap Zappy',
            'Georgina George',
        ];

        $linkedList = new LinkedList();

        foreach ($people as $person) {
            $linkedList->append(new BasicNode($person));
        }

        $sortFactory = new SortFactory();
        $linkedList->sort($sortFactory->getSorter(new SortMethod(SortMethod::COCKTAIL)));

        $index = 0;
        sort($people);

        foreach($linkedList->iterate() as $node) {
            $this->assertEquals($people[$index++], $node->getName());
        }

    }
}