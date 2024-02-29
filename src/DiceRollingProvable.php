<?php

namespace Hct\Provable;

class DiceRollingProvable implements DiceRollingProvableInterface
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
    private $multiplier=6;

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
     * @return \Hct\LimboProvable\DiceRollingProvableInterface
     */
    public static function init(string $clientSeed = null, string $serverSeed = null): DiceRollingProvableInterface
    {
        return new static($clientSeed, $serverSeed);
    }

   /**
     * client seed setter.
     * @param string $clientSeed
     * @return \Hct\Provable\DiceRollingProvableInterface
     */
    public function setClientSeed(string $clientSeed = null): DiceRollingProvableInterface
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
     * @return \Hct\Provable\DiceRollingProvableInterface
     */
    public function setServerSeed(string $serverSeed = null): DiceRollingProvableInterface
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
     * generate a random integer from server seed and client seed.
     * @return int
     */
    private function limboGenerateRandomInteger(): int
    {
        $hmac = hash_hmac('sha256', $this->getServerSeed(), $this->getClientSeed());
        $sum = array_reduce(range(0, $this->interceptNumber - 1), function ($carry, $i) use ($hmac) {
            $decimalValue = hexdec(substr($hmac, $i * $this->interceptItems, $this->interceptItems));
            return $carry +  number_format($decimalValue / ($this->divisor ** ($i+1)),12);
        }, 0);
        return  (int)($sum*$this->multiplier)+1 ;
    }
}
