<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslateResource extends JsonResource
{
    public function toArray($request)
    {

        $translate = (array) $this->resource;

        $translations = isset($translate['translations']) ? json_decode($translate['translations'], true) : [];
        $tags = isset($translate['tags']) ? json_decode($translate['tags'], true) : [];

        return [
            'key' => $translate['key'] ?? null,
            'translations' => $translations,
            'tags' => $tags,
        ];
    }
}
