<?php

namespace Tests\Unit\Domain\Collection;

use App\Domain\Collection\ArrayCollection;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use PHPUnit\Framework\TestCase;

class ArrayCollectionTest extends TestCase
{

    /**
     * @test
     */
    public function it_is_countable_an_iterator_and_has_array_access()
    {
        $collection = new ArrayCollection;

        self::assertInstanceOf(Countable::class, $collection);
        self::assertInstanceOf(IteratorAggregate::class, $collection);
        self::assertInstanceOf(ArrayAccess::class, $collection);
    }

    /**
     * @test
     */
    public function it_implements_array_access_methods_correctly()
    {
        $collection = new ArrayCollection(['item1', 'item2', 'foo' => 'bar', 'baz' => 'bingo', 'unsetthis' => 'thing']);
        $collection['ping'] = 'pong';
        $collection['baz'] = 'boz';
        $collection[] = 'appended';
        unset($collection['unsetthis']);

        self::assertEquals('pong', $collection['ping']);
        self::assertNull($collection['thiskeydoesnotexist']);
        self::assertNull($collection['unsetthis']);
    }

    /**
     * @test
     */
    public function it_can_check_whether_an_item_is_set_like_an_array()
    {
        $collection = new ArrayCollection(['foo' => 'bar']);

        self::assertTrue(isset($collection['foo']));
        self::assertFalse(isset($collection['thiskeydoesnotexist']));
    }

    /**
     * @test
     */
    public function it_can_get_an_item_from_the_collection_like_an_array()
    {
        $collection = new ArrayCollection(['item1', 'item2', 'foo' => 'bar']);

        self::assertEquals('item1', $collection[0]);
        self::assertEquals('bar', $collection['foo']);
        self::assertNull($collection['thiskeydoesnotexist']);
    }

    /**
     * @test
     */
    public function it_can_add_items_to_the_collection_like_an_array()
    {
        $collection = new ArrayCollection(['item1', 'item2', 'foo' => 'bar']);
        $collection['ping'] = 'pong';

        self::assertEquals('pong', $collection['ping']);
    }

    /**
     * @test
     */
    public function it_can_append_items_to_the_collection_like_an_array()
    {
        $collection = new ArrayCollection;
        $collection[] = 'foo';

        self::assertEquals('foo', $collection[0]);
    }


    /**
     * @test
     */
    public function it_can_unset_items_in_the_collection_like_an_array()
    {
        $collection = new ArrayCollection(['item1', 'item2', 'foo' => 'bar']);
        unset($collection['foo']);

        self::assertNull($collection['foo']);
        self::assertEquals(['item1', 'item2'], $collection->toArray());
    }

    /**
     * @test
     */
    public function it_returns_an_iterator_with_the_current_array_items()
    {
        $collection = new ArrayCollection(['item1', 'item2']);

        self::assertInstanceOf(\ArrayIterator::class, $collection->getIterator());
        self::assertCount(2, $collection->getIterator());
    }

    /**
     * @test
     */
    public function it_is_countable()
    {
        $collection = new ArrayCollection(['item1', 'item2']);

        self::assertCount(2, $collection);
    }

    /**
     * @test
     * @dataProvider provider_for_it_returns_the_collection_as_an_array
     *
     * @param array $array
     */
    public function it_returns_the_collection_as_an_array(array $array)
    {
        $collection = new ArrayCollection($array);

        self::assertEquals($array, $collection->toArray());
    }

    public function provider_for_it_returns_the_collection_as_an_array(): array
    {
        return [
            [['item1']],
            [[]],
            [['item1', 'item2']],
            [['foo' => 'bar']],
            [['foo' => ['bar' => 'baz']]],
        ];
    }

    /**
     * @test
     */
    public function it_adds_an_item_to_the_collection()
    {
        $collection = new ArrayCollection;
        $collection->add('item');

        self::assertEquals(['item'], $collection->toArray());
    }

    /**
     * @test
     * @dataProvider provider_for_it_removes_an_item_from_the_collection
     *
     * @param $key
     * @param $expectation
     * @param $itemExpectation
     */
    public function it_removes_an_item_from_the_collection($key, $expectation, $itemExpectation)
    {
        $collection = new ArrayCollection(['item1', 'foo' => 'bar']);

        $item = $collection->remove($key);

        self::assertEquals($itemExpectation, $item);
        self::assertEquals($expectation, $collection->toArray());
    }

    public function provider_for_it_removes_an_item_from_the_collection(): array
    {
        return [
            [0, ['foo' => 'bar'], 'item1'],
            ['foo', ['item1'], 'bar'],
            ['item', ['item1', 'foo' => 'bar'], false],
        ];
    }

    /**
     * @test
     */
    public function it_maps_a_function_to_the_elements()
    {
        $collection = new ArrayCollection(['item1', 'item2']);

        $results = $collection->map(
            function ($item) {
                return $item;
            }
        );

        self::assertEquals(['item1', 'item2'], $results->toArray());
    }

    /**
     * @test
     */
    public function it_filters_the_elements()
    {
        $collection = new ArrayCollection(['item1', 'item2']);

        $results = $collection->filter(
            function ($item) {
                return $item === 'item1';
            }
        );

        self::assertEquals(['item1'], $results->toArray());
    }
}
