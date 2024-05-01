<?php

declare(strict_types=1);

namespace App\ValuesObject;

use Assert\Assertion;

abstract class Collection implements \Countable, \IteratorAggregate
{
    /**
     * @param array<K, T> $items
     */
    public function __construct(protected array $items)
    {
        Assertion::allIsInstanceOf($this->items, $this->itemType());
        $this->extraValidation();
    }

    /** @return class-string> */
    abstract public static function itemType(): string;

    /** Can be overwritten to add extra validation in child classes. */
    protected function extraValidation(): void
    {
    }

    /** Can be overwritten to sort items */
    protected function sort(): static
    {
        return $this;
    }

    /**
     * @return \ArrayIterator<(int&K)|(string&K), T>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    /**
     * @return array<(int&K)|(string&K), T>
     */
    public function toArray(): array
    {
        return (array) $this->sort()->getIterator();
    }

    /**
     * @return array<int, T>
     */
    public function search(callable $callback): array
    {
        return array_values(array_filter($this->items, $callback));
    }

    /**
     * @param array<int, string> $elements
     */
    public static function fromArray(array $elements): static
    {
        $class = static::itemType();

        return new static(array_map(
            fn ($element) => in_array(\BackedEnum::class, class_implements($class), true)
                ? $class::from($element)
                : new $class($element),
            $elements,
        ));
    }

    /** @return null|T */
    public function first(): mixed
    {
        return $this->items ? $this->items[\array_key_first($this->items)] : null;
    }

    /** @return null|T */
    public function last(): mixed
    {
        return $this->items ? $this->items[\array_key_last($this->items)] : null;
    }

    /**
     * @template U
     *
     * @param callable(T): U $callable
     *
     * @return array<U>
     */
    public function mapToArray(callable $callable): array
    {
        return array_map($callable, $this->items);
    }
}
