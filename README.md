Filters
=======

Installation
------------
```sh
$ composer require geniv/nette-filters
```
or
```json
"geniv/nette-filters": "^2.1"
```

require:
```json
"php": ">=7.0",
"nette/di": ">=2.4",
"nette/neon": ">=2.4",
"nette/utils": ">=2.4"
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
{$date|czechDay}
{$date|czechMonth}
{$date|czechNameDay}

{$file|chmodText}
{$file|chmodOctal}
{$file|readable}
{$file|writable}
{$file|executable}
{$file|mtime}

{$coordinates|googleMapsLink}

{$url|toUrl}
{$baseUrl.'/../adresa/meziadresa/nic/../../'|realUrl}

{$data|neon}  {*to NEON*}
{$data|json}  {*to JSON*}
```
