<?php

namespace App\Http\Resources\v1\DeckResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_premium' => (bool) $this->is_premium,
            'creation_time' => $this->created_at->toDateTimeString(),
            "visitors_count"=> $this->visitors_count,
            "tests_count"=> $this->tests_count,
            'cards_count'=> $this->cards_count,
            'original_language' => (object)[
                'id'=>$this->originalLanguage->id,
                'name' => $this->originalLanguage->name,
                'code' => $this->originalLanguage->code,
                'flag_url' => $this->originalLanguage->flag_url,
            ],
            'target_language' => (object)[
                'id'=>$this->targetLanguage->id,
                'name' => $this->targetLanguage->name,
                'code' => $this->targetLanguage->code,
                'flag_url' => $this->targetLanguage->flag_url,
            ],
            'user' => (object)[
                'id'=>$this->user->id,
                'avatar_url'=>$this->user->avatar_url,
                'name' => $this->user->name,
            ],
            'topics' => $this->topics->map(fn($topic) => [
                'id' => $topic->id,
                'name' => $topic->name,
            ]),
            'tests' => $this->when(isset($this->tests), function () {
                return $this->tests->map(fn($test) => [
                    // Структура данных для каждого теста
                    'id' => $test->id,
                    'name' => $test->name,
                    "time_seconds"=> $test->time_seconds,
                    "count_attempts" => $test->count_attempts,
                    "creation_time"=> $test->created_at->toDateTimeString()
                ]);
            }),
            'cards' => $this->when(isset($this->cards), function () {
                return $this->cards->map(fn($card) => [
                    // Структура данных для каждого теста
                    'id' => $card->id,
                    'word'=>$card->word,
                    'translate'=>$card->translate,
                    'image_url'=>$card->image_url,
                    'pronunciation_url'=>$card->pronunciation_url,
                    'creation_time'=>$card->created_at->toDateTimeString(),
                ]);
            }),
        ];
    }
}
