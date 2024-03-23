<?php

declare(strict_types=1);

namespace App\Provable;

/**
 * Interface DiceRollProvableInterface.
 */
interface DiceRollProvableInterface
{
    /**
     * Get the client seed.
     *
     * @return string
     *   The current client seed.
     */
    public function getClientSeed(): string;
    
    /**
     * Get the hashed version of the server seed.
     *
     * @return string
     *   The hashed version of the current server seed.
     */
    public function getHashedServerSeed(): string;

    /**
     * Get the server seed.
     *
     * @return string
     *   The current server seed.
     */
    public function getServerSeed(): string;

    /**
      * Returns a random number of 0-10000 based on serverSeed and clientSeed.
     *
     * @return int
     *   The randomly generated number.
     */
    public function number(): int;

}
