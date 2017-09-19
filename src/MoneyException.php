<?php

namespace Sk\Geo;

class MoneyException extends \RuntimeException
{
    public function __construct($message = "", \Throwable $previous)
    {
        parent::__construct(
            $message.': '.$previous->getMessage(),
            $previous->getCode()
        );
    }
}
