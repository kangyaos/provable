<?php

declare(strict_types=1);

namespace App\Provable;

/**
 * Interface DiceRollingProvableInterface.
 */
interface DiceRollingProvableInterface
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
     * Returns a random number from server seed and client seed.
     *
     * @return int
     *   The randomly generated number.
     */
    public function number(): int;

}
