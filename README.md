QueryStringer
=============

A simple query string helper that will let you:

* get a query string with key/values added
* get a query string with keys removed
* combine the two
* get an array instead
* use the helper to assemble a new query string

## Usage

```php
// assume the current document's query string is britney=spears&michael=jackson
$query_stringer = new QueryStringer;

// returns ?michael=jackson
$query_stringer->without(['britney'])->get();

// returns ?britney=spears&michael=jackson&joe=schlabotnik
$query_stringer->with(['joe' => 'schlabotnik'])->get();

// returns array('britney' => 'spears', 'michael' => 'jackson')
$query_stringer->getArray();

// returns ?master=splinter
$query_stringer->replaceWith('master' => 'splinter')->get();
