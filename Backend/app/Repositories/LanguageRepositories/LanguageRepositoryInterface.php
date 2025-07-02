<?php

namespace App\Repositories\LanguageRepositories;

interface LanguageRepositoryInterface
{
    public function getAllIdLanguages();

    public function getAllLanguagesName();

    public function isExistLanguageByName(string $languageName);

    public function isExistLanguageById(int $languageId);

    public function saveLanguage(string $languageName, string $languageCode, string $urlToImage);
}
