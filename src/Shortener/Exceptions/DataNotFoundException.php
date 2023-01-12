<?php

namespace Pleskachov\PhpPro\Shortener\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{
    protected $message = 'Data not found';
}


