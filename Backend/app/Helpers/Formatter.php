<?php

namespace App\Helpers;

class Formatter
{
    public function normalizeString(string $name): string
    {
        $name = trim($name);

        if ($name === '') {
            return $name;
        }

        // Разделяем на первое слово и остаток
        $spacePos = mb_strpos($name, ' ');

        if ($spacePos === false) {
            // Только одно слово
            return mb_strtoupper(mb_substr($name, 0, 1)) . mb_substr($name, 1);
        }

        $firstWord = mb_substr($name, 0, $spacePos);
        $rest = mb_substr($name, $spacePos);

        // Возвращаем с заглавной первой буквой
        return mb_strtoupper(mb_substr($firstWord, 0, 1)) . mb_substr($firstWord, 1) . $rest;
    }

}
