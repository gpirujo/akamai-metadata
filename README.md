# Akamai metadata

This is a tool to generate the JSON hostname and rules definitions to feed into Akamai's Property Manager API.

## Preparation

The script `metadata.php` is intended to be used in the command line. Since usually you will have your configurations located somewhere else, so that you can use it everywhere, you can create an alias for it. It has a command returns the alias command line for convenience.

```
$ eval $(php metadata.php alias metadata)
# then just use "metadata" everywhere
```

## How to use

Create a new PHP file that returns a `configuration` object, in which the hostnames and the rules have been defined. More docs on available functions later.

```
$ cat >www.old.com.php
<?php

return configuration()
->hostnames([
	'www.old.com' => 'old.com.edgekey.net',
])
->rules(
	defaultRule()->isSecure()
	->behaviors([
		customerOrigin('origin.old.com'),
		cpCode(123456),
	])
);
^D
```

Use the `hostnames` command to get the hostnames of the configuration in the proper JSON format for the API.

```
$ metadata hostnames www.old.com.php
[
	{
		'cnameType': 'EDGE_HOSTNAME',
		'cnameFrom': 'www.old.com',
		'cnameTo': 'old.com.edgekey.net'
	}
]
```

Use the `rules` command to get the rules tree of the configuration in the proper JSON format for the API.

```
$ metadata rules www.old.com.php
{
    "ruleFormat": "v2019-07-25",
    "rules": {
        "name": "default",
        "behaviors": [
            {
                "name": "origin",
                "options": {
                    "hostname": "{{user.PMUSER_ORIGIN_HOSTNAME}}",
                    "originType": "CUSTOMER",
                    [...]
                }
            },
			  {
                "name": "cpCode",
                "options": {
                    "value": {
                        "id": 168931
                    }
                }
            }
        ],
        "options": {
            "is_secure": true
        }
    }
}
```

You can even feed them directly to the `akamai-cli`.

```
$ metadata hostnames www.old.com.php | papi update-property-version-hostnames $property $version $contract $group
$ metadata rules www.old.com.php | papi update-property-version-rules $property $version $contract $group
```
