<?php

namespace Exceptions;

class InvalidFileExtensionException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
