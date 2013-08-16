[![Build Status](https://travis-ci.org/mikedfunk/QueryStringer.png?branch=master)](https://travis-ci.org/mikedfunk/QueryStringer) [![Coverage Status](https://coveralls.io/repos/mikedfunk/QueryStringer/badge.png?branch=master)](https://coveralls.io/r/mikedfunk/QueryStringer)

QueryStringer
=============

A simple query string helper that will let you:

* get a query string with key/values added
* get a query string with keys removed (blacklist)
* get a query string with only a subset of keys (whitelist)
* combine any of these
* use the helper to assemble a new query string
* get the result as an array
* get the result as a string

## Installation

Add this to your composer.json:

```"mikefunk/query-stringer": "dev-master"```

then run ```composer update``` and you're ready to use query stringer!

## Usage

```php
// assume the current document's query string is britney=spears&michael=jackson
$query_stringer = new MikeFunk\QueryStringer;

// returns ?michael=jackson
$query_stringer->without(['britney'])->get();

// returns ?britney=spears&michael=jackson&joe=schlabotnik
$query_stringer->with(['joe' => 'schlabotnik'])->get();

// returns array('britney' => 'spears', 'michael' => 'jackson')
$query_stringer->getArray();

// returns ?master=splinter
$query_stringer->replaceWith('master' => 'splinter')->get();

// returns ?michael=jackson
$query_stringer->only(['michael'])->get();

// if the current document's query string is not set, returns an empty string.
// no question mark.
$query_stringer->get();
```
