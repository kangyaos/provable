<?php

namespace Hct\Provable;

class LimboProvable implements LimboProvableInterface
{
    /**
     * client seed.
     * @var string
     */
    private $clientSeed;

    /**
     * server seed.
     * @var string
     */
    private $serverSeed;

   /**
     * interceptNumber.
     * @var int
     */
    private $interceptNumber=4;

    /**
     * interceptItems.
     * @var int
     */
    private $interceptItems=2;

     /**
     * multiplier.
     * @var int
     */
    private $multiplier=2 ** 24;

    /**
     * divisor.
     * @var int
     */
    private $divisor=256;
    


    /**
     * class constructor.
     * @param string $clientSeed
     * @param string $serverSeed
     */
    public function __construct(string $clientSeed = null, string $serverSeed = null)
    {
        $this->setClientSeed($clientSeed);
        $this->setServerSeed($serverSeed);
    }

    /**
     * static constructor.
     * @param string $clientSeed
     * @param string $serverSeed
     * @return \Hct\LimboProvable\LimboProvableInterface
     */
    public static function init(string $clientSeed = null, string $serverSeed = null): LimboProvableInterface
    {
        return new static($clientSeed, $serverSeed);
    }

    /**
     * client seed setter.
     * @param string $clientSeed
     * @return \Hct\Provable\LimboProvableInterface
     */
    public function setClientSeed(string $clientSeed = null): LimboProvableInterface
    {
        $this->clientSeed = $clientSeed ?? $this->generateRandomSeed();

        return $this;
    }

    /**
     * client seed getter.
     * @return string
     */
    public function getClientSeed():  string
    {
        return $this->clientSeed;
    }

    /**
     * server seed setter.
     * @param string $serverSeed
     * @return \Hct\Provable\LimboProvableInterface
     */
    public function setServerSeed(string $serverSeed = null): LimboProvableInterface
    {
        $this->serverSeed = $serverSeed ?? $this->generateRandomSeed();

        return $this;
    }

    /**
     * server seed getter.
     * @return string
     */
    public function getServerSeed(): string
    {
        return $this->serverSeed;
    }

    /**
     * generate a random seed.
     * @var int
     * @return string
     */
    private function generateRandomSeed(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    /**
     * returns a random number within a range.
     * @return int
     */
    public function number() :int
    {
        return generateRandomInteger();
    }

    /**
     * generate a random integer from server seed and client seed.
     * @return int
     */
    private function generateRandomInteger(): int
    {
        $hmac = hash_hmac('sha256', $this->getServerSeed(), $this->getClientSeed());
        $sum = array_reduce(range(0, $this->interceptNumber - 1), function ($carry, $i) use ($hmac) {
            $decimalValue = hexdec(substr($hmac, $i * $this->interceptItems, $this->interceptItems));
            return $carry +  number_format($decimalValue / ($this->divisor ** ($i+1)),12);
        }, 0);
        return  (int)($sum*$this->multiplier) ;
    }
}
