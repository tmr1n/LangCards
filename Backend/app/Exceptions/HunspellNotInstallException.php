<?php

namespace App\Exceptions;

use Exception;

class HunspellNotInstallException extends Exception
{
    public function __construct()
    {
        parent::__construct("Пакет Hunspell не установлен в системе!");
    }
}
