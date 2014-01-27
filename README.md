# Bump

[![Build Status](https://travis-ci.org/gajus/bump.png?branch=master)](https://travis-ci.org/gajus/bump)
[![Coverage Status](https://coveralls.io/repos/gajus/bump/badge.png)](https://coveralls.io/r/gajus/bump)

Bump (or "Better Dump") is a debugging tool to dump variable content excluding the existing buffer.

## Bells and whistles

* Bump will convert non-printable (control) characters (characters that would force browser to download output as `application/octet-stream`) to their hexadecimal presentation.
* Bump will append human-readable version of each UNIX timestamp.

## Use

```php
<?php
echo 'A lot of content that I do not want to see in my debug output.';

bump('test', 1390850756);
```

Will produce plain/text output:

```
string(4) "test"
int(1390850756) <== 2014-01-27 19:25:56

Backtrace:

#0  bump(test, 1390850756) called at [/var/dev/gajus/bump/tests/bin/bump_test.php:4]
```

## Setup

Use composer if you are planning to use Bump only with certain projects.

However, since I use this function across all of my projects in the development environment, I prefer to have it available without definining the composer dependency. Therefore, I use [auto_prepend_file](http://uk1.php.net/manual/en/ini.core.php#ini.auto-prepend-file) setting to load `./src/gajus/bump/bump.php`.

## Todo

* How about integration with JavaScript console.log?