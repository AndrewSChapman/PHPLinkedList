# PHPLinkedList
Implements a linked list data structure in PHP, with support for iteration, arbitrary insertion and deletion, 
swapping and sorting.

## Installation
composer install

## Usage
In order to use the LinkedList, you must first implement a "Node" class.  There's a BasicNode implementation
in the ChapmanDigital\LinkedList\Node folder you can use as a reference.  Your "Node" must implement
the "NodeInterface" and you can extent AbstractNode to make the process quick and simple.

A node can hold any information you like, however you must implement the "compare" method, which 
will compare one node against another, and determine if one node is less than / equal to / greater than the
other.

Here's the BasicNode code for reference - it holds a single variable "Name" and uses
that as the basis of node comparison.

```
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
```

Once you've coded your node, you can use the list like so:

```
$linkedList = new LinkedList();

// Adding node
$linkedList->append(new BasicNode('Pickle Rick'));
$linkedList->append(new BasicNode('Morty'));

// Iteration
foreach ($linkedList->iterate() as $node) {
    // Do stuff with your node
}

// Reversing the list
$linkedList->reverse();

// Sorting
$sortFactory = new SortFactory();
$linkedList->sort($sortFactory->getSorter(new SortMethod(SortMethod::COCKTAIL)));
```

There are also methods for inserting and removing nodes at a specified position, and for swapping nodes.

See the LinkedListTest file in tests\Unit\LinkedList for more details.

