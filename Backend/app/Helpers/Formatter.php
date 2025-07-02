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
    public function normalizeSentence(string $sentence): string
    {
        // Удаляем пробелы в начале и конце
        $normalized  = trim($sentence);

        // Заменяем множественные пробелы одним
        $normalized = preg_replace('/\s+/', ' ', $normalized);
        // 3. Пробел после знаков пунктуации внутри строки + заглавная буква
        $normalized = preg_replace_callback(
            '/([.!?])\s*(\p{L})/u',
            function ($matches) {
                return $matches[1] . ' ' . mb_strtoupper($matches[2], 'UTF-8');
            },
            $normalized
        );

        // Добавляем точку в конце, если нет знака конца предложения
        if (!preg_match('/[.!?]$/u', $normalized)) {
            $normalized .= '.';
        }

        return $normalized;
    }
}
