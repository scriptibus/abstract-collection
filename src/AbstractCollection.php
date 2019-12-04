<?php declare(strict_types=1);

namespace Scriptibus\AbstractCollection;

use ArrayAccess;
use Countable;
use Generator;
use Iterator;
use TypeError;

abstract class AbstractCollection implements Iterator, ArrayAccess, Countable
{
    private array $objects;
    private Generator $generator;

    public function __construct(object ...$objects)
    {
        if (!is_array($objects)) {
            $objects = [$objects];
        }
        $this->objects = $objects;
        $this->generator = $this->createGeneratorFromArray();
    }

    abstract protected static function getClass(): string;

    private function createGeneratorFromArray(): Generator
    {
        foreach ($this->objects as $object) {
            yield $object;
        }
    }

    final public function offsetExists($offset): bool
    {
        return isset($this->objects[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->objects[$offset];
    }

    final public function offsetSet($offset, $value): void
    {
        if (!is_object($value) || !is_a($value, static::getClass())) {
            throw new TypeError(sprintf(
                'Argument 2 passed to BookCollection::offsetSet hast to be of type %s, %s given',
                static::getClass(),
                gettype($value)
            ));
        }
        if (isset($offset)) {
            $this->objects[$offset] = $value;
        } else {
            $this->objects[] = $value;
        }
    }

    final public function offsetUnset($offset): void
    {
        unset($this->objects[$offset]);
    }

    final public function toArray(): array
    {
        return $this->objects;
    }

    public function current()
    {
        return $this->generator->current();
    }

    final public function next(): void
    {
        $this->generator->next();
    }


    final public function key()
    {
        return $this->generator->key();
    }

    final public function valid(): bool
    {
        return $this->generator->valid();
    }

    final public function rewind(): void
    {
        if ($this->generator->valid()) {
            $this->generator->rewind();
        } else {
            $this->generator = $this->createGeneratorFromArray();
        }
    }

    final public function count(): int
    {
        return count($this->objects);
    }
}
