# Provable

This package provides the means to create provibly fair random numbers and provably fair random shuffles.

## Installation

via composer:
```
composer require hct/limb-provable
```

## Basic Useage

```php
use Hct\Provable\LimboProvable;


// set some vars
$clientSeed = 'your client seed here';
$serverSeed = 'your server seed here';


// instanciate the provable class
$provable = new LimboProvable($clientSeed, $serverSeed);

// get the results
print $provable->number();
```

## Methods

### __construct(string $clientSeed = null, string $serverSeed = null)

The class constructor takes the optional parameters, clientSeed, serverSeed, min, max, and type. If clientSeed or serverSeed are not provided, it will generate random seeds automatically. The min and max parameters are the minimum and maximum values of the random number or shuffle. Type is either `number` or `shuffle`.


### setClientSeed(string $clientSeed = null)

This sets the client seed. If no seed is provided, one will be automatically generated. The Provable instance is returned allowing you to chain commands.

### getClientSeed()

This returns the current client seed.

### setServerSeed(string $serverSeed = null)

This sets the server seed. If no seed is provided, one will be automatically generated. The Provable instance is returned allowing you to chain commands.

### getServerSeed()

This returns the current server seed.

### getHashedServerSeed()

This calculates the random number or shuffle and returns it.

### number()





