<?php

namespace App\Http\Controllers\Api\Doctors;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctors\AiRequest;
use App\Services\AiModelService;
use Illuminate\Support\Arr;

class AiController extends Controller
{
    public function __construct(protected AiModelService $model)
    {
    }

    public function result(AiRequest $request): JsonResponse
    {
        try {
            $file = $request->file('file');

            $data = $request->safe();
            if (Arr::has($request->validated(), 'file')) {
                $data = $data->merge([
                    'filePath' => $file->getRealPath(),
                    'fileName' => $file->getClientOriginalName(),
                ]);
            }

            $data = Arr::map($data->toArray(), function ($value, $key) {
                if (in_array($key, ['filePath', 'fileName', 'model', 'file'])) {
                    return $value;
                }

                return intval($value);
            });

            $response = $this->model->predict($data);

            return $this->sendResponse(
                ['result' => $response->body()],
                'Result sent successfully',
                code: 200
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), code: 404);
        }
    }
}
