Filters
=======

Installation
------------
```sh
$ composer require geniv/nette-filters
```
or
```json
"geniv/nette-filters": ">=1.0"
```

internal dependency:
```json
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
{$variable|mailto}
```
