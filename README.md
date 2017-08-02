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
"php": ">=5.6.0",
"nette/nette": ">=2.4.0"
```

neon configure extension:
```neon
extensions:
    - Filters\Bridges\Nette\Extension
```

usage:
```latte
{$variable|addText:'tag'}
{$variable|mailto|noescape}
```
