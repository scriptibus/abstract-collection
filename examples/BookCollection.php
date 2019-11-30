<?php declare(strict_types=1);

namespace Scriptibus\AbstractCollection\Examples;

use Scriptibus\AbstractCollection\AbstractCollection;

class BookCollection extends AbstractCollection
{
    protected static function getClass(): string
    {
        return Book::class;
    }

    public function offsetGet($offset): Book
    {
        return parent::offsetGet($offset);
    }

    public function __construct(Book ...$books)
    {
        parent::__construct(... $books);
    }

    public function current(): Book
    {
        return parent::current();
    }
}
