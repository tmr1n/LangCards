<?php

namespace App\Exceptions;

use Exception;

class ProcessHunspellCheckException extends Exception
{
    public function __construct()
    {
        parent::__construct("Произошла ошибка при работе утилиты Hunspell");
    }
}
