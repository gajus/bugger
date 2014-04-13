# Bump

[![Build Status](https://travis-ci.org/gajus/bump.png?branch=master)](https://travis-ci.org/gajus/bump)
[![Coverage Status](https://coveralls.io/repos/gajus/bump/badge.png)](https://coveralls.io/r/gajus/bump)

Bump is a tool for debugging code. Bump is exposed via three functions.

#### `dump ( mixed $expression [, mixed $... ] )`

Dumps information about a variable.

* Bump will convert non-printable (control) characters (characters that would force browser to download output as `application/octet-stream`) to their hexadecimal presentation.
* Bump will append human-readable version of each UNIX timestamp.

#### `sack ( mixed $expression [, mixed $... ] )`

Dumps information about all variables passed to sack funtion at the end of the script execution.

#### `tick ( int $true_after [, string $namespace = 'default' ] )`

Counts number of function invocations and returns `true` when desired number is reached.