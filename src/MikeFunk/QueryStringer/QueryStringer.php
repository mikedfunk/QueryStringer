<?php
/**
 * @package QueryStringer
 * @copyright 2013 Xulon Press, Inc. All Rights Reserved.
 */
namespace MikeFunk\QueryStringer;

/**
 * QueryStringer
 *
 * @author Mike Funk <mike@mikefunk.com>
 */
class QueryStringer
{
    /**
     * include these extra key/value pairs in the query string
     *
     * @var array
     * @access protected
     */
    protected $include = array();

    /**
     * exclude these key/value pairs from the query string
     *
     * @var array
     * @access protected
     */
    protected $exclude = array();

    /**
     * the current query string parsed to an array
     *
     * @var array
     * @access protected
     */
    protected $query_array;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        // set the current parsed query string
        $this->query_array = parse_str($_SERVER['QUERY_STRING'], $query_array);
    }

    /**
     * get the modified query string array
     *
     * @return array
     */
    public function getArray()
    {
        // add the stuff to be added
        $query_array = array_merge($this->query_array, $this->include);

        // remove the stuff to be removed
        foreach ($this->exclude as $key => $value) {
            if (isset($query_array[$key])) {
                unset($query_array[$key]);
            }
        }

        // clear the arrays and get the result
        $this->include = $this->exclude = array();
        return $query_array;
    }

    /**
     * get the assembled new string
     *
     * @return string
     */
    public function get()
    {
        // get the assembled array and clear the temp arrays
        $query_array = $this->getArray();
        $this->include = $this->exclude = array();

        // put a ? in front if there is anything in the string, return it
        $prefix = !empty($query_array) ? '?' : '';
        return $prefix . http_build_query($query_array);
    }

    /**
     * add a set of key/value pairs to the list of pairs to add
     *
     * @param array $include
     * @return QueryStringer
     */
    public function with(array $include)
    {
        $this->include = array_merge($this->include, $include);
        return $this;
    }

    /**
     * replace the current parsed query array completely
     *
     * @return QueryStringer
     */
    public function replaceWith(array $replace)
    {
        $this->query_array = $replace;
        return $this;
    }

    /**
     * add to the list of stuff to exclude from the final query string
     *
     * @param array $exclude
     * @return QueryStringer
     */
    public function without(array $exclude)
    {
        $this->exclude = array_merge($this->exclude, $exclude);
        return $this;
    }
}
