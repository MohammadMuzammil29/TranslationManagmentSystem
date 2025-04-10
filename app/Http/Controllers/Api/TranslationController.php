<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Translation\TranslationRequest;
use App\Repositories\Interfaces\TranslateRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TranslateResource;
use Illuminate\Http\Request;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;

class TranslationController extends BaseController
{
    protected $translateRepository;

    public function __construct(TranslateRepositoryInterface $translateRepository)
    {
        $this->translateRepository = $translateRepository;
    }

    /**
     * Get Translation
     *
     * @return JsonResponse
    */
    public function get(): JsonResponse
    {
        try {
            $translation = $this->translateRepository->get();

            if (!$translation) {
                return response()->json([
                    'message' => 'Translation not found'
                ], 404);
            }

            $translationFormat = TranslateResource::collection($translation);

            $data = [
                'data' => $translationFormat,
                'current_page' => $translation->currentPage(),
                'last_page' => $translation->lastPage(),
                'per_page' => $translation->perPage(),
                'total' => $translation->total(),
                'next_page_url' => $translation->nextPageUrl(),
                'prev_page_url' => $translation->previousPageUrl(),
            ];
            return $this->sendResponse('Translation fetched successfully', $data);

        } catch (\Exception $e) {
            return $this->sendError('Error fetching translation', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Translation Create
     *
     * @param Request $request
     * @return JsonResponse
    */
    public function store(TranslationRequest $request): JsonResponse
    {
        try {
            $data = $request->all();
            $translation = $this->translateRepository->create($data);
            $translationFormat = new TranslateResource($translation);

            return $this->sendResponse('Translation stored successfully', $translationFormat);

        } catch (\Exception $e) {

            return $this->sendError('Translation Store Failed', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Update Translation
     *
     * @param Request $request
     * @return JsonResponse
    */
    public function update(string $id, TranslationRequest $request): JsonResponse
    {
        try {
            $data = $request->all();
            $updated = $this->translateRepository->update($id, $data);

            return $this->sendResponse('Translation updated successfully', new TranslateResource($updated));

        } catch (\Exception $e) {
            return $this->sendError('Error fetching translation', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Search Translation
     *
     * @param Request $request
     * @return JsonResponse
    */
    public function search(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['key', 'tags', 'translations']);
            $translations = $this->translateRepository->search($filters);

            $translationFormat = TranslateResource::collection($translations);

            $data = [
                'data' => $translationFormat,
                'current_page' => $translations->currentPage(),
                'last_page' => $translations->lastPage(),
                'per_page' => $translations->perPage(),
                'total' => $translations->total(),
                'next_page_url' => $translations->nextPageUrl(),
                'prev_page_url' => $translations->previousPageUrl(),
            ];
            return $this->sendResponse('Translations fetched successfully', $data);

        } catch (\Exception $e) {
            return $this->sendError('Error fetching translation', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Search Translation
     *
     * @return JsonResponse
    */
    public function export(): JsonResponse
    {
        $translations = DB::table('translations')->get();

        $formattedTranslations = $translations->mapWithKeys(function ($translation) {
            $decodedTranslations = json_decode($translation->translations, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $decodedTranslations = [];
            }

            return [
                $translation->key => $decodedTranslations
            ];
        });

        return $this->sendResponse('Translations fetched successfully', $formattedTranslations);
    }
}
