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

## Mump

Mump ("Multiple Dump") is similar to `dump`, except it will not stop the script execution. However, if `mump` is called, then at the end of the script execution output will be flushed and replaced with dump of everything passed to `mump`, e.g.

```php
<?php
echo 1;
mump('a');
echo 2;
mump('b');
echo 3;
mump('c');
```

Will produce output:

```
string(1) "a"

Backtrace:

#0  mump(a) called at [/var/dev/gajus/bump/tests/bin/mump.php:3]

string(1) "b"

Backtrace:

#0  mump(b) called at [/var/dev/gajus/bump/tests/bin/mump.php:5]

string(1) "c"

Backtrace:

#0  mump(a) called at [/var/dev/gajus/bump/tests/bin/mump.php:7]
```

## Tick

Tick will return `true` when it is called a specified number of times, e.g.

```php
<?php
$i = 100;

while ($i--) {
    if (tick(5)) {
        bump($i);
    }
}
```

Will produce:

```
int(95)

Backtrace:

#0  bump(95) called at [/var/dev/gajus/bump/tests/bin/tick.php:6]
```

## Setup

* Use [composer](https://packagist.org/packages/gajus/bump) if you are planning to use Bump only with certain projects.
* Use [auto_prepend_file](http://uk1.php.net/manual/en/ini.core.php#ini.auto-prepend-file) setting to load `./src/gajus/bump/bump.php` to make it available across the development environment.