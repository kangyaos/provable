<?php

namespace App\Provable;



/*
* Class ShuffleProvable   

*/
class ShuffleProvable implements ShuffleProvableInterface
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
     * min default 0.
     * @var int
     */
    private $min;

    /**
     * max default 24.
     * @var int
     */
    private $max;

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
     * Divisor.
     * @var int
     */
    private $divisor = 256;
    
    /**
     * Class constructor.
     * @param string|null $clientSeed
     * @param string|null $serverSeed
     */
    public function __construct(?string $clientSeed = null, ?string $serverSeed = null, ?int $min = null, ?int $max = null)
    {
        $this->setClientSeed($clientSeed);
        $this->setServerSeed($serverSeed);
        $this->setMin($min);
        $this->setMax($max);
    }

    /**
     * Static constructor.
     * @param string|null $clientSeed
     * @param string|null $serverSeed
     * @return \App\ShuffleProvable\ShuffleProvableInterface
     */
    public static function init(?string $clientSeed = null, ?string $serverSeed = null): ShuffleProvableInterface
    {
        return new static($clientSeed, $serverSeed);
    }

    /**
     * Client seed setter.
     * @param string|null $clientSeed
     * @return \App\Provable\ShuffleProvableInterface
     */
    public function setClientSeed(?string $clientSeed = null): ShuffleProvableInterface
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
     * @return \App\Provable\ShuffleProvableInterface
     */
    public function setServerSeed(?string $serverSeed = null): ShuffleProvableInterface
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
     * min setter.
     * @param int|null $min
     * @return \App\Provable\ShuffleProvableInterface
     */
    public function setMin(?int $min = null): ShuffleProvableInterface
    {
        $this->min = $min??0;
        return $this;
    }

    /**
     * min getter.
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }


     /**
     * max setter.
     * @param int|null $max
     * @return \App\Provable\ShuffleProvableInterface
     */
    public function setMax(?int $max = null): ShuffleProvableInterface
    {
        $this->max = $max??24;
        return $this;
    }

    /**
     * max getter.
     * @return int
     */
    public function getMAx(): int
    {
        return $this->max;
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
     * Generate the result of the shuffle operation
     *
     * @return array The result of the shuffle operation
     */
    public function result(): array
    {
        return $this->shuffle();
    }

    /**
     * Shuffle the array of integers using HMAC-based shuffling algorithm
     *
     * @return array The shuffled array with x and y coordinates
     */
    private function shuffle(): array
    {
        try {
            // Validate client seed pattern
            $clientSeedPattern = '/^\w+:\d+:\d+$/';
            if (!preg_match($clientSeedPattern, $this->clientSeed)) {
                // If client seed pattern does not match, return error
                return $this->returnError();
            }
            
            // Generate an array of integers from min to max
            $array = range($this->getMin(), $this->getMax());
            $length = count($array);
            
            // Calculate the number of HMAC iterations
            $hmacNum = ceil($length - 1 / 32);
            
            // Generate HMAC
            $hmac = hash_hmac('sha256', $this->serverSeed, $this->clientSeed);
            
            // Trim client seed to prepare for subsequent iterations
            $lastColonPosition = strrpos($this->clientSeed, ":");
            $trimmedString = substr($this->clientSeed, 0, $lastColonPosition + 1);
            
            // Iterate to generate HMAC for subsequent iterations
            for ($i = 1; $i < $hmacNum; $i++) {
                $clientSeed = $trimmedString . $i;
                $hmac .= hash_hmac('sha256', $this->serverSeed, $clientSeed);
            }
            
            // Shuffle the array using Fisher-Yates algorithm
            for ($i = 0; $i < $length - 1; $i++) {
                $decimalValue = hexdec(substr($hmac, $i * $this->interceptItems, $this->interceptItems));
                $decimalValue = $decimalValue / $this->divisor;
                $random = (int)($decimalValue * ($length - $i));
                $temp = $array[$i];
                $array[$i] = $array[$i + $random];
                $array[$i + $random] = $temp;
            }
            
            // Prepare result array with x and y coordinates
            $result = [];
            foreach ($array as $value) {
                $x = ($value % 5) + 1;
                $y = 5 - floor($value / 5);
                $result[] = ['x' => $x, 'y' => $y];
            }
            
            // Return success with result
            return $this->returnSuccess($result);      
        } catch (Exception $e) {
            // If any exception occurs, return error with error message
            return $this->returnError($e->getMessage());
        }
       
    }

    // Return error
    function returnError(?string $msg = null) {
        // Default error message
        $defaultMsg = "clientSeed invalid";
        
        // If a custom message is provided, use it; otherwise, use the default message
        $msg = $msg ?? $defaultMsg;
        
        // Return error response with code 500 and error message
        return ['code' => 500, 'msg' => $msg];
    }

    // Return success
    function returnSuccess(?array $data = null) {
        // Return success response with code 200 and optional data
        return ['code' => 200, 'data' => $data];
    }

}
