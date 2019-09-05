<?php
/**
 * Phollections — $file.nameName
 * Copyright (c) 2019. Łukasz Kondracki
 * Last modified: 05.09.2019, 20:47
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Phollections\Collection;

final class CollectionTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            Collection::class,
            new Collection(1, 2, 3, 4, 5)
        );
    }

    public function testCanBeCreatedFromArray(): void
    {
        $this->assertEquals(
            new Collection(1, 2, 3, 4, 5),
            (new Collection())->fromArray([1, 2, 3, 4, 5])
        );
    }

    public function testCanBeConvertedToArray(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5))->toArray(),
            [1, 2, 3, 4, 5]
        );
    }

    public function testCanBeGenerated(): void
    {
        $this->assertEquals(
            (new Collection())->generate(5, static function($x) { return $x * 2 + 1; }),
            new Collection(1, 3, 5, 7, 9)
        );
    }

    public function testCanBeFilled(): void
    {
        $this->assertEquals(
            (new Collection())->fill(5, 'hello'),
            new Collection('hello', 'hello', 'hello', 'hello', 'hello')
        );
    }

    public function testCanBeCounted(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5))->count(),
            5
        );
    }

    public function testCanHaveLastIndex(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5))->lastIndex(),
            4
        );
    }

    public function testCanBeAddedTo(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5))->add(6),
            new Collection(1, 2, 3, 4, 5, 6)
        );
    }

    public function testCanBeAddedToAt(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 4, 5))->addAt(3, 2),
            new Collection(1, 2, 3, 4, 5)
        );
    }

    public function testCanBeGottenFrom(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5))->get(0),
            1
        );
    }

    public function testCanBePoppedFrom(): void
    {
        $collection = new Collection(1, 2, 3, 4, 5);
        $result = $collection->pop();

        $this->assertEquals(
            $collection,
            new Collection(1, 2, 3, 4)
        );

        $this->assertEquals(
            $result,
            5
        );
    }

    public function testCanBePoppedFromIndex(): void
    {
        $collection = new Collection(1, 2, 3, 4, 5);
        $result = $collection->popFrom(1);

        $this->assertEquals(
            $collection,
            new Collection(1, 3, 4, 5)
        );

        $this->assertEquals(
            $result,
            2
        );
    }

    public function testFirstElementCanBeGotten(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5))->first(),
            1
        );
    }

    public function testLastElementCanBeGotten(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5))->last(),
            5
        );
    }

    public function testCanBeCulled(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5, 6, 7, 8, 9, 10))->cull(static function($x) { return $x % 2 !== 0; }),
            new Collection(1, 3, 5, 7, 9)
        );
    }

    public function testCanHaveEachElementModified(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5))->each(static function($x) { return $x * 2; }),
            new Collection(2, 4, 6, 8, 10)
        );
    }

    public function testCanBeSplit(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5, 6))->split(2),
            new Collection(
                new Collection(1, 2, 3),
                new Collection(4, 5, 6)
            )
        );
    }

    public function testCanBeTrimmed(): void
    {
        $this->assertEquals(
            (new Collection(1, 2, 3, 4, 5, 6, 7))->trim(1, 1),
            new Collection(2, 3, 4, 5, 6)
        );
    }

    public function testCanBeCastToString(): void
    {
        $this->assertEquals(
            (string) new Collection(1, 2, 3, 4, 5),
            '[1, 2, 3, 4, 5]'
        );
    }

}
