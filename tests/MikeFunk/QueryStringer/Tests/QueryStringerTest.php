<?php
/**
 * @package QueryStringer
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace MikeFunk\Tests;

use Mockery;
use MikeFunk\QueryStringer\QueryStringer;

/**
 * QueryStringerTest
 *
 * @author Michael Funk <mike@mikefunk.com>
 */
class QueryStringerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        // set up the query string, create a new test QueryStringer
        $this->query_string   = 'one=1&two=2';
        $this->query_stringer = new QueryStringer($this->query_string);
        $this->query_string   = '?' . $this->query_string;
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        // just so mockery works right
        Mockery::close();
    }
    /**
     * testGet
     *
     * @return void
     */
    public function testGet()
    {
        // make sure we get the same string
        $this->assertEquals($this->query_string, $this->query_stringer->get());
    }

    /**
     * functional test to ensure the array gets added to the end string
     *
     * @return void
     */
    public function testWith()
    {
        $add_array = array('orangered' => 'red');
        $result    = $this->query_stringer->with($add_array)->get();
        $expected  = $this->query_string . '&orangered=red';
        $this->assertEquals($expected, $result);
    }

    /**
     * testWithout
     *
     * @return void
     */
    public function testWithout()
    {
        $remove_array = array('two');
        $result       = $this->query_stringer->without($remove_array)->get();
        $expected     = '?one=1';
        $this->assertEquals($expected, $result);
    }

    /**
     * testGetArray
     *
     * @return void
     */
    public function testGetArray()
    {
        $actual = $this->query_stringer->getArray();
        $expected = array('one' => '1', 'two' => '2');
        $this->assertEquals($expected, $actual);
    }

    /**
     * testReplaceWith
     *
     * @return void
     */
    public function testReplaceWith()
    {
        $new_array = array('giant' => 'flame');
        $expected  = '?giant=flame';
        $actual    = $this->query_stringer->replaceWith($new_array)->get();
        $this->assertEquals($expected, $actual);
    }
}
