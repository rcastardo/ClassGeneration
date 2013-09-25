<?php

/**
 * ClassGenerator
 *
 * Copyright (c) 2012 ClassGenerator
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   ClassGenerator
 * @package    ClassGenerator
 * @copyright  Copyright (c) 2012 ClassGenerator (https://github.com/tonicospinelli/ClassGenerator)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */

namespace ClassGeneration\Test\Collection;

use ClassGeneration\Collection\ArrayCollection;

/**
 * Test Collection ClassGenerator
 *
 * @category   ClassGenerator
 * @package    ClassGenerator
 * @copyright  Copyright (c) 2012 ClassGenerator (https://github.com/tonicospinelli/ClassGenerator)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
class ArrayCollectionTest extends \PHPUnit_Framework_TestCase
{

    public function testCreatingInstanceOfArrayCollection()
    {
        $collection = new ArrayCollection();
        $this->assertInstanceOf('\ClassGeneration\Collection\ArrayCollection', $collection);
    }

    public function testCreatingInstanceOfArrayCollectionWithArgument()
    {
        $collection = new ArrayCollection(array('test'));
        $this->assertCount(1, $collection);
    }

    public function testAddingElementInArrayCollection()
    {
        $collection = new ArrayCollection();
        $collection->add('first');
        $this->assertCount(1, $collection);
    }

    public function testClearingElementsInArrayCollection()
    {
        $collection = new ArrayCollection(array('first'));
        $collection->clear();
        $this->assertCount(0, $collection);
    }

    public function testContainsElementInArrayCollection()
    {
        $collection = new ArrayCollection(array('first'));
        $this->assertTrue($collection->contains('first'));
    }

    public function testContainsKeyInArrayCollection()
    {
        $collection = new ArrayCollection(array('first'));
        $this->assertTrue($collection->containsKey(0));
    }

    public function testCurrentElementInArrayCollection()
    {
        $collection = new ArrayCollection(array('current'));
        $this->assertEquals('current', $collection->current());
    }

    public function testExistsKeyInArrayCollection()
    {
        $collection = new ArrayCollection(array('current'));
        $this->assertTrue($collection->exists(0));
    }

    public function testExistsElementInArrayCollection()
    {
        $collection = new ArrayCollection(array('current'));
        $this->assertTrue($collection->exists(null, 'current'));
    }

    public function testExistsElementInPositionInArrayCollection()
    {
        $collection = new ArrayCollection(array('current'));
        $this->assertTrue($collection->exists(0, 'current'));
    }

    public function testReturnFirstElementInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertTrue($collection->first() == 'first');
    }

    public function testGetElementInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertTrue($collection->get(0) == 'first');
    }

    public function testGetIteratorInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertInstanceOf('\ClassGeneration\Collection\CollectionIterator', $collection->getIterator());
    }

    public function testGetArrayKeysInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $keys = $collection->getKeys();
        $this->assertTrue(is_array($keys));
        $this->assertEquals(0, $keys[0]);
    }

    public function testGetArrayValuesInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $values = $collection->getValues();
        $this->assertTrue(is_array($values));
        $this->assertEquals('first', $values[0]);
    }

    public function testIndexOfInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertEquals(0, $collection->indexOf('first'));
    }

    public function testIsEmptyInArrayCollection()
    {
        $collection = new ArrayCollection();
        $this->assertTrue($collection->isEmpty());
        $collection->add('element');
        $this->assertFalse($collection->isEmpty());
    }

    public function testKeyInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertEquals(0, $collection->key());
    }

    public function testLastInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertEquals('last', $collection->last());
    }

    public function testNextInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertEquals('first', $collection->current());
        $collection->next();
        $this->assertEquals('last', $collection->current());
    }

    public function testOffsetExistsInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertTrue($collection->offsetExists(0));
    }

    public function testOffsetGetInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertEquals('first', $collection->offsetGet(0));
    }

    public function testOffsetSetInArrayCollection()
    {
        $collection = new ArrayCollection(array('element', 'last'));
        $collection->offsetSet(0, 'first');
        $this->assertEquals('first', $collection->first());
    }

    public function testOffsetUnsetInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));

        $this->assertEquals('first', $collection->first());
        $collection->offsetUnset(0);
        $this->assertEquals('last', $collection->first());
    }

    public function testRemoveInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertEquals('first', $collection->first());
        $collection->remove(0);
        $this->assertEquals('last', $collection->first());
    }

    public function testRemoveElementInArrayCollection()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $this->assertEquals('first', $collection->first());
        $collection->removeElement('first');
        $this->assertEquals('last', $collection->first());
    }

    public function testSetInArrayCollection()
    {
        $collection = new ArrayCollection(array('element', 'last'));
        $collection->set(0, 'first');
        $this->assertEquals('first', $collection->first());
    }

    public function testSliceInArrayCollection()
    {
        $collection = new ArrayCollection(array(0, 1, 2, 3, 4, 5));
        $slice = $collection->slice(0);
        $this->assertCount(6, $slice);
        $slice = $collection->slice(2);
        $this->assertCount(4, $slice);
        $slice = $collection->slice(2, 1);
        $this->assertCount(1, $slice);
    }

    public function testSortAscInArrayCollection()
    {
        $collection = new ArrayCollection(array(5, 4, 3, 2, 1, 0));
        $this->assertEquals(5, $collection->first());
        $collection->sortAsc();
        $this->assertEquals(5, $collection->last());
    }

    public function testSortDescInArrayCollection()
    {
        $collection = new ArrayCollection(array(0, 1, 2, 3, 4, 5));
        $this->assertEquals(0, $collection->first());
        $collection->sortDesc();
        $this->assertEquals(0, $collection->last());
    }

    public function testConvertArrayCollectionToArray()
    {
        $collection = new ArrayCollection(array('first', 'last'));
        $array = $collection->toArray();
        $this->assertTrue(is_array($array));
        $this->assertEquals('first', $array[0]);
    }
}