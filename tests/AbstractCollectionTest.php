<?php declare(strict_types=1);

namespace Scriptibus\AbstractCollection\Tests;

use PHPUnit\Framework\TestCase;
use Scriptibus\AbstractCollection\AbstractCollection;
use Scriptibus\AbstractCollection\Examples\Book;
use Scriptibus\AbstractCollection\Examples\BookCollection;
use Scriptibus\AbstractCollection\Examples\Car;
use TypeError;

class AbstractCollectionTest extends TestCase
{
    public function testConstruct(): void
    {
        $books = new BookCollection();
        self::assertInstanceOf(AbstractCollection::class, $books);
    }

    public function testConstructWithOneObject(): void
    {
        $book = new Book('A');
        $books = new BookCollection($book);
        self::assertSame([$book], [...$books]);
        self::assertCount(1, $books);
    }

    public function testConstructWithMultipleObjects(): void
    {
        $bookA = new Book('A');
        $bookB = new Book('B');
        $bookC = new Book('C');
        $books = new BookCollection($bookA, $bookB, $bookC);
        self::assertEquals([$bookA, $bookB, $bookC], [...$books]);
        self::assertCount(3, $books);
    }

    public function testConstructFailsWithAnotherObject(): void
    {
        $this->expectException(TypeError::class);
        $car = new Car();
        $books = new BookCollection($car);
    }

    public function testPushFailsWithAnotherObject(): void
    {
        $this->expectException(TypeError::class);
        $books = new BookCollection();
        $car = new Car();
        $books[] = $car;
    }

    public function testForeach(): void
    {
        $bookA = new Book('A');
        $bookB = new Book('B');
        $bookC = new Book('C');
        $books = new BookCollection($bookA, $bookB, $bookC);
        $arr = [];
        foreach ($books as $book) {
            $arr[] = $book;
        }
        self::assertCount(3, $arr);
    }

    public function testToArray(): void
    {
        $bookA = new Book('A');
        $bookB = new Book('B');
        $bookC = new Book('C');
        $books = new BookCollection($bookA, $bookB, $bookC);
        $arr = [$bookA, $bookB, $bookC];
        self::assertEquals($arr, $books->toArray());
    }

    public function testSetSpecificOffset(): void
    {
        $book = new Book('A');
        $books = new BookCollection();
        $books['A'] = $book;
        self::assertSame($book, $books['A']);
    }
}
