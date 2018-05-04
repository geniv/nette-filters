Filters
=======

Installation
------------
```sh
$ composer require geniv/nette-filters
```
or
```json
"geniv/nette-filters": ">=1.0.0"
```

require:
```json
"php": ">=7.0.0",
"nette/nette": ">=2.4.0"
```

neon configure extension:
```neon
extensions:
    - Filters\Bridges\Nette\Extension
```

`dateDiff` use: http://php.net/manual/en/class.dateinterval.php (via format)

usage:
```latte
{$variable|addText:'tag'}
{$variable|mailto|noescape}
{$date1|dateDiff:$date2:'format'}
{$coordinates|googleMapsLink}
```
