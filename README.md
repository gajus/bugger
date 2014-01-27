# Bump

[![Build Status](https://travis-ci.org/gajus/bump.png?branch=master)](https://travis-ci.org/gajus/bump)
[![Coverage Status](https://coveralls.io/repos/gajus/bump/badge.png)](https://coveralls.io/r/gajus/bump)

Bump (or "Better Dump") is a debugging tool to dump variable content excluding the existing buffer.

## Bells and whistles

Bump will strip out non-printable characters (characters that browser would now allow you to display and would force to download output as `application/octet-stream`). Of course, there will be small warning letting you know that you might need to further investigate the output.

Bump will also find all UNIX timestamps and add a nice little comment next to it with human-readable time.

## Use

```php
echo 'A lot of content that I do not want to see in my debug output.';

bump('foo', 'bar');
```

Will produce plain/text output:

```
string(4) "test"
int(1390850484) <== 2014-01-27 19:21:24

Backtrace:

#0  bump(test, 1390850484) called at [/var/www/dev/bump/tests/bump.php:3]
```

## Setup

Obviously, you can use composer. However, since I use this function across all of my projects and only when developing/debugging, I prefer to have it available without defined composer dependency. In which case, you can use [auto_prepend_file](http://uk1.php.net/manual/en/ini.core.php#ini.auto-prepend-file) setting to load `./src/gajus/bump/bump.php`.

## Todo

* How about integration with JavaScript console.log?