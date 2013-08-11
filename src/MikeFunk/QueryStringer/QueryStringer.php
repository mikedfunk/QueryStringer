<?php
class QueryString
{
    protected $include = array();
    protected $exclude = array();
    protected $query_array;

    public function __construct()
    {
        $this->query_array = parse_str($_SERVER['QUERY_STRING'], $query_array);
    }
    public function getArray()
    {
        $query_array = array_merge($query_array, $this->include);
        foreach ($this->exclude as $key => $value) {
            if (isset($query_array[$key])) {
                unset($query_array[$key]);
            }
        }
        $this->include = $this->exclude = array();
        return $query_array;
    }
    public function get()
    {
        $query_array = $this->getArray();
        $this->include = $this->exclude = array();
        $prefix = !empty($query_array) ? '?' : '';
        return $prefix . http_build_query($query_array);
    }
    public function with(array $include)
    {
        $this->include = array_merge($this->include, $include);
        return $this;
    }

    public function replaceWith(array $replace)
    {
        $this->query_array = $replace;
        return $this;
    }
    public function without(array $exclude)
    {
        $this->exclude = array_merge($this->exclude, $exclude);
        return $this;
    }
}
