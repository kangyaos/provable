<?php

namespace App\Provable;

class CoinFupProvable implements CoinFupProvableInterface
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
    private $interceptNumber = 4;

    /**
     * Intercept items.
     * @var int
     */
    private $interceptItems = 2;

    /**
     * Multiplier.
     * @var int
     */
    private $multiplier = 2;

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
     * @return \App\LimboProvable\CoinFupProvableInterface
     */
    public static function init(?string $clientSeed = null, ?string $serverSeed = null): CoinFupProvableInterface
    {
        return new static($clientSeed, $serverSeed);
    }

    /**
     * Client seed setter.
     * @param string|null $clientSeed
     * @return \App\Provable\CoinFupProvableInterface
     */
    public function setClientSeed(?string $clientSeed = null): CoinFupProvableInterface
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
     * @return \App\Provable\CoinFupProvableInterface
     */
    public function setServerSeed(?string $serverSeed = null): CoinFupProvableInterface
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
     * Returns a random number .
     * @return int
     */
    public function number(): int
    {
        return $this->generateRandomInteger();
    }

    /**
     * Generate a random number of 1-2 based on serverSeed and clientSeed.
     * @return int
     */
    private function generateRandomInteger(): int
    {
        $hmac = hash_hmac('sha256', $this->getServerSeed(), $this->getClientSeed());
        $sum = array_reduce(range(0, $this->interceptNumber - 1), function ($carry, $i) use ($hmac) {
            $decimalValue = hexdec(substr($hmac, $i * $this->interceptItems, $this->interceptItems));
            return $carry + number_format($decimalValue / ($this->divisor ** ($i + 1)), 12);
        }, 0);

        //Generate random numbers from 0 to 1
        $random = (int) ($sum * $this->multiplier);

        // Change 0-1 to 1-2
        return $random + 1;
    }
}
