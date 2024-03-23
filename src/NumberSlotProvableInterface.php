<?php

declare(strict_types=1);

namespace App\Provable;

/**
 * Interface NumberSlotProvableInterface.
 */
interface NumberSlotProvableInterface
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
     *  Generate 3-digit 0-9 random numbers.
     *
     * @return int
     *   The randomly generated  integer array.
     */
    public function result(): array;
}
