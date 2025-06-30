<?php

namespace App\Repositories\LanguageRepositories;

interface LanguageRepositoryInterface
{
    public function getAllLanguagesName();

    public function isExistLanguageByName(string $languageName);

    public function saveLanguage(string $languageName, string $languageCode, string $urlToImage);
}
