<?php
/**
 * Created by Ricardo.
 * Date: 22-10-15
 * Time: 11:30
 */

namespace Domain\Collections;


use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use JsonSerializable;
use OutOfRangeException;

/**
 * A collection of objects with a specified class or interface
 */
class Collection implements Countable, IteratorAggregate, JsonSerializable
{
	/**
	 * The collection's encapsulated array
	 *
	 * @var array
	 */
	protected $items;
	/**
	 * The name of the object, either class or interface, that the list works with
	 *
	 * @var string
	 */
	private $objectName;

	/**
	 * Instantiates the collection by specifying what type of Object will be used.
	 *
	 * @param array $items
	 * @param string $objectName Name of the class or interface used in the Collection
	 */
	public function __construct(array $items = array(), $objectName = "collection")
	{
		$this->items      = $items;
		$this->objectName = $objectName;
	}

	/**
	 * Clones the collection by cloning each object in the underlying array
	 */
	public function __clone()
	{
		$clone       = function ($object) {
			return clone $object;
		};
		$this->items = array_map($clone, $this->items);
	}

	/**
	 * Fetches the name of the object that the list works with
	 */
	public function getObjectName()
	{
		return $this->objectName;
	}

	/**
	 * Add an item to the collection
	 *
	 * @param mixed $item An item of your Collection's object type to be added
	 */
	public function add($item)
	{
		$this->validateItem($item);
		$this->items[] = $item;
	}

	/**
	 * @param $item
	 */
	public function addIfNotExists($item)
	{
		$this->validateItem($item);
		if (!in_array($item, $this->items)) {
			$this->items[] = $item;
		}
	}

	/**
	 * An array of items to add to the collection
	 *
	 * @param array $items An array of items of your Collection's object type to be added
	 */
	public function addRange(array $items)
	{
		$this->validateItems($items);
		$this->items = array_merge($this->items, $items);
	}

	/**
	 * An array of items to add to the collection
	 *
	 * @param array $items An array of items of your Collection's object type to be added
	 * @return $this
	 */
	public function addRangeNoRepeat(array $items)
	{
		foreach ($items as $item) {
			$this->addIfNotExists($item);
		}

		return $this;
	}

	/**
	 * Fetches the item at the specified index
	 *
	 * @param integer $index The index of an item to fetch
	 * @throws InvalidArgumentException
	 * @throws OutOfRangeException
	 * @return mixed The item at the specified index
	 */
	public function at($index)
	{
		$this->validateIndex($index);

		return $this->items[$index];
	}

	/**
	 * Empties all of the items in the array
	 */
	public function clear()
	{
		$this->items = [];
	}

	/**
	 * Determines whether the item is in the Collection
	 *
	 * @param mixed $needle The item to search for in the collection
	 * @return bool Whether the item was in the array or not
	 */
	public function contains($needle)
	{
		$this->validateItem($needle);

		return in_array($needle, $this->items);
	}

	/**
	 * The number of items in a collection
	 *
	 * @return integer The number of items in the collection
	 */
	public function count()
	{
		return count($this->items);
	}

	/**
	 * Check to see if an item in the collection exists that satisfies the provided callback
	 *
	 * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
	 * @return bool Whether an item exists that satisfied the condition
	 */
	public function exists(callable $condition)
	{
		return (bool)$this->find($condition);
	}

	/**
	 * Finds and returns the first item in the collection that satisfies the callback.
	 *
	 * @param callback $condition The condition critera to test each item, requires one argument that represents the Collection item during iteration.
	 * @return mixed|bool The first item that satisfied the condition or false if no object was found
	 */
	public function find(callable $condition)
	{
		$index = $this->findIndex($condition);

		return $index == -1 ? false : $this->items[$index];
	}

	/**
	 * @return mixed
	 */
	public function first()
	{
		if (!$this->isEmpty()) {
			return $this->at(0);
		}
		throw new \InvalidArgumentException("Empty collection");
	}

	/**
	 * Returns a collection of all items that satisfy the callback function. If nothing is found, returns an empty
	 * Collection
	 *
	 * @param callable $condition
	 * @return Collection A collection of all of the items that satisfied the condition
	 */
	public function findAll(callable $condition)
	{
		$class = get_class($this);

		/** @var Collection $col */
		$col = new $class();

		foreach ($this->items as $item) {
			if ($condition($item)) {
				$col->add($item);
			}
		}

		return $col;
	}

	/**
	 * Finds the index of the first item that returns true from the callback,
	 * returns -1 if no item is found
	 *
	 * @param callback $condition The condition critera to test each item, requires one toargument that represents the Collection item during iteration.
	 * @return integer The index of the first item satisfying the callback or -1 if no item was found
	 */
	public function findIndex(callable $condition)
	{
		$index = -1;
		for ($i = 0; $i < count($this->items); $i++) {
			if ($condition($this->at($i))) {
				$index = $i;
				break;
			}
		}

		return $index;
	}

	/**
	 * Finds and returns the last item in the collection that satisfies the callback.
	 *
	 * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
	 * @return mixed|bool The last item that matched condition or -1 if no item was found matching the condition.
	 */
	public function findLast(callable $condition)
	{
		$index = $this->findLastIndex($condition);

		return $index == -1 ? false : $this->items[$index];
	}

	/**
	 * Returns the last element of the collection. False if is empty.
	 *
	 * @return bool|mixed
	 */
	public function last()
	{
		$count = $this->count();

		return $count == 0 ? false : $this->items[$count - 1];
	}

	/**
	 * Finds the index of the last item that returns true from the callback,
	 * returns -1 if no item is found
	 *
	 * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
	 * @return integer The index of the last item  to match that matches the condition, returns -1 if no item was found
	 */
	public function findLastIndex(callable $condition)
	{
		$index = -1;
		for ($i = count($this->items) - 1; $i >= 0; $i--) {
			if ($condition($this->items[$i])) {
				$index = $i;
				break;
			}
		}

		return $index;
	}

	/**
	 * Get Iterator to satisfy IteratorAggregate interface
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}

	/**
	 * Get a range of items in the collection
	 *
	 * @param integer $start The starting index of the range
	 * @param integer $end The ending index of the range
	 * @return Collection A collection of items matching the range
	 */
	public function getRange($start, $end)
	{

		if ($this->count() == 0) {
			$class = get_class($this);

			return new $class();
		}
		if ($this->count() > 0 && $this->count() <= $end) {
			$end = $this->count() - 1;
		}
		if ($start == 0 && $end == 0) {
			$class = get_class($this);

			return new $class();
		}
		if (!is_integer($start) || $start < 0) {
			throw new InvalidArgumentException("Start must be a non-negative integer");
		}
		if (!is_integer($end) || $end < 0) {
			throw new InvalidArgumentException("End must be a positive integer");
		}
		if ($start > $end) {
			$class = get_class($this);
			return new $class();
		}
		if ($start >= $this->count()) {
			throw new InvalidArgumentException("Start must be less than the count of the items in the Collection");
		}
		if ($end >= $this->count()) {
			throw new InvalidArgumentException("End must be less than the count of the items in the Collection");
		}
		$length      = $end - $start + 1;
		$subsetItems = array_slice($this->items, $start, $length);
		$class       = get_class($this);

		$subset = new $class($subsetItems);

		return $subset;
	}

	/**
	 * Insert the item at index
	 *
	 * @throws InvalidArgumentException
	 * @param integer $index The index where to insert the item
	 * @param mixed $item The item to insert
	 */
	public function insert($index, $item)
	{
		$this->validateIndex($index);
		$this->validateItem($item);
		$partA       = array_slice($this->items, 0, $index);
		$partB       = array_slice($this->items, $index, count($this->items));
		$partA[]     = $item;
		$this->items = array_merge($partA, $partB);
	}

	/**
	 * Inset a range at the index
	 *
	 * @param integer $index Index where to insert the range
	 * @param array $items
	 * @internal param array $An of items to insert
	 */
	public function insertRange($index, array $items)
	{
		$this->validateIndex($index);
		$this->validateItems($items);
		//To work with negative index, get the positive relation to 0 index
		$index < 0 && $index = $this->count() + $index + 1;
		$partA       = array_slice($this->items, 0, $index);
		$partB       = array_slice($this->items, $index, count($this->items));
		$this->items = array_merge($partA, $items);
		$this->items = array_merge($this->items, $partB);
	}

	/**
	 * Removes the first item that satisfies the condition callback
	 *
	 * @param callback $condition The condition critera to test each item, requires one argument that represents the Collection item during iteration.
	 * @return bool Whether the item was found
	 */
	public function remove(callable $condition)
	{
		$index = $this->findIndex($condition);
		if ($index == -1) {
			return false;
		} else {
			$this->removeAt($index);

			return true;
		}
	}

	/**
	 * Removes all items that satisfy the condition callback
	 *
	 * @param callback $condition The condition criteria to test each item, requires on argument that represents the Collection item during interation.
	 * @return int the number of items found
	 */
	public function removeAll(callable $condition)
	{
		$removed = 0;
		while ($this->remove($condition)) {
			$removed++;
		}

		return $removed;
	}

	/**
	 * Removes the item at the specified index
	 *
	 * @param integer $index The index where the object should be removed
	 */
	public function removeAt($index)
	{
		$this->validateIndex($index);
		$partA       = array_slice($this->items, 0, $index);
		$partB       = array_slice($this->items, $index + 1, count($this->items));
		$this->items = array_merge($partA, $partB);
	}

	/**
	 * Removes the last item to satisfy the condition callback
	 *
	 * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
	 * @return bool Whether the item was removed or not
	 */
	public function removeLast(callable $condition)
	{
		$index = $this->findLastIndex($condition);
		if ($index == -1) {
			return false;
		} else {
			$this->removeAt($index);

			return true;
		}
	}

	/**
	 * Reverses the Collection
	 */
	public function reverse()
	{
		$this->items = array_reverse($this->items);
	}

	/**
	 * Sorts the collection with a usort
	 *
	 * @param callable $callback
	 * @return bool
	 */
	public function sort(callable $callback)
	{
		return usort($this->items, $callback);
	}

	/**
	 * Return the collection as an array
	 *
	 * Returns the array that is encapsulated by the collection.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return $this->items;
	}

	/**
	 * @return array
	 */
	public function allInArray()
	{
		$result = [];
		foreach ($this->items as &$value) {
			$tmp = $value;
			if (is_object($value) && method_exists($value, 'allInArray')) {
				$tmp = $value->allInArray();
			}

			$result[] = $tmp;
		}

		return $result;
	}

	/**
	 * Validates a number to be used as an index
	 *
	 * @param integer $index The number to be validated as an index
	 * @throws OutOfRangeException
	 * @throws InvalidArgumentException
	 */
	private function validateIndex($index)
	{
		if (!is_int($index)) {
			throw new InvalidArgumentException("Index must be an integer");
		}
		if ($index < 0) {
			throw new InvalidArgumentException("Index must be a non-negative integer");
		}
		if ($index > $this->count()) {
			throw new OutOfRangeException("Index out of bounds of collection");
		}
	}

	/**
	 * Validates that the item is an object and matches the object name
	 *
	 * @param mixed $item The item to be validated
	 */
	protected function validateItem($item)
	{
		if (!is_object($item)) {
			// throw new InvalidArgumentException("Item must be an object");
		}

	}

	/**
	 * Validates an array of items
	 *
	 * @param array $items an array of items to be validated
	 */
	protected function validateItems(array $items)
	{
		foreach ($items as $item) {
			$this->validateItem($item);
		}
	}

	/**
	 * Checks if collection is empty
	 *
	 * @return bool
	 */
	public function isEmpty()
	{
		return empty($this->items);
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize()
	{

		foreach ($this->items as &$value) {
			if (is_object($value) && method_exists($value, 'jsonSerialize')) {
				$value = $value->jsonSerialize();
			}
		}

		return $this->items;
	}
}