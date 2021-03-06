<?php

namespace Enqueue\Router;

use Enqueue\Psr\PsrDestination;
use Enqueue\Psr\PsrMessage;

class Recipient
{
    /**
     * @var PsrDestination
     */
    private $destination;

    /**
     * @var PsrMessage
     */
    private $message;

    /**
     * @param PsrDestination $destination
     * @param PsrMessage     $message
     */
    public function __construct(PsrDestination $destination, PsrMessage $message)
    {
        $this->destination = $destination;
        $this->message = $message;
    }

    /**
     * @return PsrDestination
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return PsrMessage
     */
    public function getMessage()
    {
        return $this->message;
    }
}
