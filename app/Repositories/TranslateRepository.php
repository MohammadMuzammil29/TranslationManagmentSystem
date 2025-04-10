<?php

namespace App\Repositories;

use App\Models\Translation;
use App\Repositories\Interfaces\TranslateRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TranslateRepository implements TranslateRepositoryInterface
{
    public function create(array $data)
    {
        $insertedId = DB::table('translations')->insertGetId([
            'key' => $data['key'],
            'translations' => is_array($data['translations']) ? json_encode($data['translations']) : $data['translations'],
            'tags' => isset($data['tags'])
                ? (is_array($data['tags']) ? json_encode($data['tags']) : $data['tags'])
                : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]); 

        return DB::table('translations')->select('id', 'key', 'translations', 'tags')->find($insertedId);
    }

    public function get(int $perPage = 10) {

        return DB::table('translations')
            ->select('id', 'key', 'translations', 'tags', 'created_at', 'updated_at')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function update(int $id, array $data)
    {
        $translations = is_array($data['translations']) ? json_encode($data['translations']) : $data['translations'];
        $tags = isset($data['tags']) && is_array($data['tags']) ? json_encode($data['tags']) : $data['tags'];

        $updateTranslate = DB::table('translations')
            ->where('id', $id)
            ->update([
                'translations' => $translations,
                'tags' => $tags,
                'updated_at' => now(),
            ]);

        $translation = DB::table('translations')->where('id', $id)->first();
        return $translation;
    }

    public function search(array $filters)
    {
        $query = DB::table('translations');

        if (!empty($filters['key'])) {
            $query->where('key', 'like', '%' . $filters['key'] . '%');
        }

        if (!empty($filters['tags'])) {
            $tags = is_array($filters['tags']) ? $filters['tags'] : [$filters['tags']];
            foreach ($tags as $tag) {
                $query->whereJsonContains('tags', $tag);
            }
        }

        if (!empty($filters['translations'])) {
            $query->where('translations', 'like', '%' . $filters['translations'] . '%');
        }

        return $query->paginate(10);
    }


}
