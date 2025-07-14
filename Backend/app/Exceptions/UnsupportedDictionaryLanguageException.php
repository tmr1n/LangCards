<?php

namespace App\Exceptions;

use Exception;

class UnsupportedDictionaryLanguageException extends Exception
{
    public function __construct(string $language)
    {
        parent::__construct("Не установлен словаря для языка с кодом $language");
    }
}
