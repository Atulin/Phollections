<?php
/**
 * Phollections — $file.nameName
 * Copyright (c) 2019. Łukasz Kondracki
 * Last modified: 05.09.2019, 20:32
 */

declare(strict_types=1);

namespace Phollections;
/**
 * Class Collection
 * @package Phollections
 */
class Collection
{
    /** @var array $array */
    private $array;

    /**
     * Collection constructor.
     *
     * @param array $elements, ... Elements of the collection
     */
    public function __construct(...$elements)
    {
        $this->array = $elements;
    }

    /**
     * Creates a Collection from an existing array.
     * If the array is associative, only values are preserved.
     * @param array $array  Array to turn into a collection
     *
     * @return Collection
     */
    public function fromArray(array $array): Collection
    {
        $this->array = array_values($array);
        return $this;
    }

    /**
     * Converts the collection into a regular PHP array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->array;
    }

    /**
     * Generates a Collection based on the given generator
     * @param int      $count       Number of elements in the resulting Collection
     * @param callable $generator   Generator to use. Called with 0..$count as the parameter
     *
     * @return Collection
     */
    public function generate(int $count, callable $generator): Collection
    {
        $out = [];
        for ($i = 0; $i < $count; $i++) {
            $out[] = $generator($i);
        }
        $this->array = $out;
        return $this;
    }

    /**
     * Fill collection with $count copies of $value
     * @param int        $count   Number of elements
     * @param mixed|null $value   Value to fill the Collection with
     *
     * @return Collection
     */
    public function fill(int $count, $value = null): Collection
    {
        $this->array = array_fill(0, $count, $value);
        return $this;
    }

    /**
     * Returns the number of elements in the collection
     * @return int
     */
    public function count(): int
    {
        return count($this->array);
    }

    /**
     * Returns the last index of the Collection
     * @return int
     */
    public function lastIndex(): int
    {
        return $this->count() - 1;
    }

    /**
     * Adds an element to the collection
     * @param mixed $element  Element to add
     *
     * @return Collection
     */
    public function add($element): Collection
    {
        $this->array[] = $element;
        return$this;
    }

    /**
     * Adds an element at the desired index and shifts the rest accordingly
     * @param mixed $element    Element to add
     * @param int   $index      Index at which to add the element
     *
     * @return Collection
     */
    public function addAt($element, int $index): Collection
    {
        array_splice($this->array, $index, 0, $element);
        return $this;
    }

    /**
     * Returns an element at $index
     * @param int $index    Index of the desired element
     *
     * @return mixed
     */
    public function get(int $index)
    {
        return $this->array[$index];
    }

    /**
     * Removes the last element fromm the array and returns it
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->array);
    }

    /**
     * Removes the element at $index and returns it
     * @param int $index    Index of the desired element
     *
     * @return mixed
     */
    public function popFrom(int $index)
    {
        $out = $this->array[$index];
        array_splice($this->array, $index, 1);
        return $out;
    }

    /**
     * Returns the first element of the Collection
     * @return mixed
     */
    public function first()
    {
        return $this->array[0];
    }

    /**
     * Returns the last element of the Collection
     * @return mixed
     */
    public function last()
    {
        return $this->array[$this->lastIndex()];
    }

    /**
     * Culls the entire Collection, removing any element for which $filter doesn't return `true`
     * @param callable $filter  Filter to apply
     *
     * @return Collection
     */
    public function cull(callable $filter): Collection
    {
        $this->array = array_values(array_filter($this->array, $filter));
        return $this;
    }

    /**
     * Calls $modifier on every element of the Collection
     * @param callable $modifier    Modifier to apply
     *
     * @return Collection
     */
    public function each(callable $modifier): Collection
    {
        $this->array = array_map($modifier, $this->array);
        return $this;
    }

    /**
     * Splits the Collection into a Collection of two Collections after the given $index
     * @param int  $index    Index on which to split the Collection
     *
     * @return Collection
     */
    public function split(int $index): Collection
    {
        [$first, $second] = array_chunk($this->array, $index+1, false);
        return new self(
            (new self())->fromArray($first),
            (new self())->fromArray($second)
        );
    }

    /**
     * Trims $left elements from the start and $right elements from the end
     * @param int $left     Number of elements to trim from the start
     * @param int $right    Number of elements to trim from the end
     *
     * @return $this
     */
    public function trim(int $left, int $right): Collection
    {
        $this->array = array_slice($this->array, $left, $this->lastIndex() - $right);
        return $this;
    }

    /**
     * Returns the collection as a string
     * @return string
     */
    public function __toString()
    {
        return '['.implode(', ', $this->array).']';
    }

}
