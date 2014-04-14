# Bugger

[![Build Status](https://travis-ci.org/gajus/bugger.png?branch=master)](https://travis-ci.org/gajus/bugger)
[![Coverage Status](https://coveralls.io/repos/gajus/bugger/badge.png)](https://coveralls.io/r/gajus/bugger)

Bugger is a collection of functions for debugging PHP code. Use it to:

* Dump information about a variable
* Set breakpoints in loops

## API

### Trace

```php
/**
 * Terminates the script, discards the output buffer, dumps information about the expression including backtrace up to the `trace` call.
 * 
 * @param mixed $expression The variable you want to dump.
 * @return null
 */
trace ( mixed $expression )
````

### Stack

```php
/**
 * Stacks information about the expression and dumps the stack at the end of the script execution.
 *
 * @param mixed $expression The variable you want to dump.
 * @return null
 */
stack ( mixed $expression )
```



### Tick

```php
/**
 * Tracks the number of times tick function itself has been called and returns true
 * when the desired number within the namespace is reached.
 *
 * @param int $true_after Number of the itteration after which response is true.
 * @param string $namespace Itteration namespace.
 * @return boolean
 */
tick ( int $true_after [, string $namespace = 'default' ] )
```

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