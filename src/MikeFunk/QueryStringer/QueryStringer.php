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
    public function __construct($query_string = '')
    {
        // set the current parsed query string to either the server one or
        // the one passed in
        if ($query_string == '') {
            parse_str($_SERVER['QUERY_STRING'], $query_array);
        } else {
            parse_str($query_string, $query_array);
        }
        $this->query_array = $query_array;
    }

    /**
     * get the modified query string array
     *
     * @return array
     */
    public function getArray()
    {
        // clear the array and get the result
        $return = $this->query_array;
        $this->query_array = array();
        return $return;
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
        // add the stuff to be added
        $this->query_array = array_merge($this->query_array, $include);
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
        // remove the stuff to be removed
        foreach ($exclude as $item) {
            if (isset($this->query_array[$item])) {
                unset($this->query_array[$item]);
            }
        }
        return $this;
    }

    /**
     * get rid of any keys in the stored array that don't match these
     *
     * @param array $only
     * @return QueryStringer
     */
    public function only(array $only)
    {
        // reset exclude and include arrays
        $this->exclude = $this->include = array();

        // create new array from keys sent and values in query_array
        $output = array();
        foreach($only as $key)
        {
            $output[$key] = $this->query_array[$key];
        }

        // set it, return object for chaining
        $this->query_array = $output;
        return $this;
    }
}
