<?php

namespace App\Repositories\TopicRepositories;

interface TopicRepositoryInterface
{
    public function isExistByName(string $name): bool;
    public function saveNewTopic($topicName);
}
