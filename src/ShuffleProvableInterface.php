<?php

declare(strict_types=1);

namespace App\Provable;

/**
 * Interface ShuffleProvableInterface.
 */
interface ShuffleProvableInterface
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
     * Get the max.
     *
     * @return int
     *   The current max.
     */
    public function getMax(): int;

    /**
     * Get the min.
     *
     * @return int
     *   The current min.
     */
    public function getMin(): int;

    /**
     * Shuffle the array of integers using HMAC-based shuffling algorithm
     *
     * @return array The shuffled array with x and y coordinates
     */
    public function result(): array;
}
