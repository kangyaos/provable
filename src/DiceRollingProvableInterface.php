<?php

declare(strict_types=1);

namespace Hct\Provable;

/**
 * Interface ProvableInterface.
 */
interface DiceRollingProvable
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
    public function getServerSeed(): string;


  /**
     * Returns a random number from server seed and client seed.
     *
     * @return int
     *   The randomly generated number.
     */
    public function number(): int;

}