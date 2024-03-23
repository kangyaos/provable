# Provable

This package provides the means to create provibly fair random numbers and provably fair random shuffles.

## Installation

via composer:
```
composer require app/limb-provable
```

## Basic Useage

```php
use App\Provable\*Provable;


// set some vars
$clientSeed = 'your client seed here';
$serverSeed = 'your server seed here';


// instanciate the LimboProvable class
 $provable = new LimboProvable($clientSeed, $serverSeed);

// get the results
print $provable->number();
// prints 1413608,2949514,3221509,16592804,5788257,262595,13785104,...

// instanciate the DiceRollingProvable class
$provable = new DiceRollingProvable($clientSeed, $serverSeed)

// Returns a random number of 1-6.
print $provable->number();
// prints 1,2,6,5,3,2,...

// instanciate the CoinFupProvable class
$provable = new CoinFupProvable($clientSeed, $serverSeed)

// Returns a random number of 1-2.
print $provable->number();
// prints 1,2,1,1,2,1,...

// instanciate the DiceRollProvable class
$provable = new DiceRollProvable($clientSeed, $serverSeed)

// Returns a random number of 0-10000.
print $provable->number();
// prints 456,8957,3589,...

// instanciate the CoinFupProvable class
$provable = new KPSProvable($clientSeed, $serverSeed)

// Returns a random number of 1-3.
print $provable->number();
// prints 1,2,2,3,2,1,...

// instanciate the NumberSlotProvable class
$provable = new NumberSlotProvable($clientSeed, $serverSeed)

// Returns 3-digit 0-9 random numbers.
print $provable->result();
// prints [1,6,5],[3,6,8],[9,2,5],...

// instanciate the ShuffleProvable class   algorithm
// clientSeed  xxxx:number:0 
// min defaults to 0  
// max  defaults to 24
$provable = new ShuffleProvable($clientSeed, $serverSeed,$min,$max);

// Shuffle the array of integers using HMAC-based shuffling
// Successfully returned {code:200,data:[{'x':1,'y':2},{'x':2,'y':5},{'x':3,'y':2}....]}
// Failure return {code:500,msg:'clientSeed invalid'}
print $provable->result();

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





