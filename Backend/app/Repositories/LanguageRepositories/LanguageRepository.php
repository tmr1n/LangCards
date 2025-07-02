<?php

namespace App\Repositories\LanguageRepositories;

use App\Models\Language;

class LanguageRepository implements LanguageRepositoryInterface
{
    protected Language $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    public function getAllLanguagesName()
    {
        return $this->model->select('name')->get()->toArray();
    }

    public function isExistLanguageByName(string $languageName)
    {
        return $this->model->where('name', $languageName)->exists();
    }

    public function saveLanguage(string $languageName, string $languageCode, string $urlToImage): void
    {
        $newLanguage = new Language();
        $newLanguage->name = $languageName;
        $newLanguage->code = $languageCode;
        $newLanguage->flag_url = $urlToImage;
        $newLanguage->save();
    }

    public function getAllIdLanguages()
    {
        return $this->model->select(['id'])->get()->toArray();
    }

    public function isExistLanguageById(int $languageId)
    {
        return $this->model->where('id', '=', $languageId)->exists();
    }
}
