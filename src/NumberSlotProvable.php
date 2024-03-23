<?php

namespace App\Provable;

class NumberSlotProvable implements NumberSlotProvableInterface
{
    /**
     * Client seed.
     * @var string
     */
    private $clientSeed;

    /**
     * Server seed.
     * @var string
     */
    private $serverSeed;

    /**
     * Intercept number.
     * @var int
     */
    private $interceptNumber =3;

    /**
     * Intercept items.
     * @var int
     */
    private $interceptItems = 2;

    /**
     * Multiplier.
     * @var int
     */
    private $multiplier = 10;

    /**
     * Divisor.
     * @var int
     */
    private $divisor = 256;
    
    /**
     * Class constructor.
     * @param string|null $clientSeed
     * @param string|null $serverSeed
     */
    public function __construct(?string $clientSeed = null, ?string $serverSeed = null)
    {
        $this->setClientSeed($clientSeed);
        $this->setServerSeed($serverSeed);
    }

    /**
     * Static constructor.
     * @param string|null $clientSeed
     * @param string|null $serverSeed
     * @return \App\NumberSlotProvable\NumberSlotProvableInterface
     */
    public static function init(?string $clientSeed = null, ?string $serverSeed = null): NumberSlotProvableInterface
    {
        return new static($clientSeed, $serverSeed);
    }

    /**
     * Client seed setter.
     * @param string|null $clientSeed
     * @return \App\Provable\NumberSlotProvableInterface
     */
    public function setClientSeed(?string $clientSeed = null): NumberSlotProvableInterface
    {
        $this->clientSeed = $clientSeed ?? $this->generateRandomSeed();
        return $this;
    }

    /**
     * Client seed getter.
     * @return string
     */
    public function getClientSeed(): string
    {
        return $this->clientSeed;
    }

    /**
     * Server seed setter.
     * @param string|null $serverSeed
     * @return \App\Provable\NumberSlotProvableInterface
     */
    public function setServerSeed(?string $serverSeed = null): NumberSlotProvableInterface
    {
        $this->serverSeed = $serverSeed ?? $this->generateRandomSeed();
        return $this;
    }

    /**
     * Server seed getter.
     * @return string
     */
    public function getServerSeed(): string
    {
        return $this->serverSeed;
    }

    /**
     * Generate a random seed.
     * @return string
     */
    private function generateRandomSeed(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    /**
     * Hashed server seed getter.
     * @return string
     */
    public function getHashedServerSeed(): string
    {
        return hash('sha256', $this->getServerSeed());
    }

    /**
     * random integer array .
     * @return array
     */
    public function result(): array
    {
        return $this->generateRandomIntegerArray();
    }

    /**
     * Generate an array of random integers
     *
     * @return array The array of random integers
     */
    private function generateRandomIntegerArray(): array
    {
        // Generate HMAC using provided key and data
        $hmac = hash_hmac('sha256', $key, $data);
        
        // Use array_reduce to generate an array of random integers
        $result = array_reduce(range(0, $this->interceptNumber - 1), function ($carry, $i) use ($hmac) {
            // Extract a portion of HMAC and convert it to decimal value
            $decimalValue = hexdec(substr($hmac, $i * $this->interceptItems, $this->interceptItems));
            
            // Calculate random integer using divisor and multiplier
            $decimalValue = $decimalValue / $this->divisor;
            $random = (int) ($decimalValue * $this->multiplier);
            
            // Add the random integer to the result array
            $carry[] = $random;
            return $carry;
        }, []);
        
        // Return the resulting array of random integers
        return $result;
    }
}
