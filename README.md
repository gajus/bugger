# Bugger

[![Build Status](https://travis-ci.org/gajus/bugger.png?branch=master)](https://travis-ci.org/gajus/bugger)
[![Coverage Status](https://coveralls.io/repos/gajus/bugger/badge.png)](https://coveralls.io/r/gajus/bugger)

Bugger is a collection of functions for debugging PHP code. Use it to:

* Dump information about a variable
* Set breakpoints in loops

## API

### Dump

```php
Bugger::dump ( mixed $expression [, mixed $... ] )
````

Dumps information about a variable.



* Bump will convert non-printable (control) characters (characters that would force browser to download output as `application/octet-stream`) to their hexadecimal presentation.
* Bump will human-readable version of each UNIX timestamp.

### Sack

```php
Bugger::sack ( mixed $expression [, mixed $... ] )
```

Dumps information about all variables passed to sack funtion at the end of the script execution.

### Tick

```php
Bugger::tick ( int $true_after [, string $namespace = 'default' ] )
```

Counts number of function invocations and returns `true` when desired number is reached.

## Installation

The recommended way to use Bugger is through Composer.

```json
{
    "require": {
       "gajus/bugger": "0.1.*"
    }
}
```

If you want to use Bugger across the server, then use [auto_prepend_file](http://uk1.php.net/manual/en/ini.core.php#ini.auto-prepend-file) setting to load `./src/autoload.php`.

## Roadmap

* Support CLI.