<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class AiModelService
{
    protected $models;

    public function __construct()
    {
        $this->models = [
            'chest' => 5000,
            'cancer' => 5001,
            'brain' => 5002,
            'kidney' => 5003,
            'diabetes' => 5004,
            'breast' => 5005
        ];
    }

    public function getModelPort(string $model): ?int
    {
        return $this->models[$model] ?? null;
    }

    public function predict(array $data): Response
    {
        $port = $this->getModelPort($data['model']);

        if (!$port) {
            throw new \Exception('Model not found');
        }

        $url = "http://127.0.0.1:{$port}/predict";

        Arr::forget($data, 'model');

        if (Arr::has($data, 'filePath') && Arr::has($data, 'fileName')) {
            return Http::attach('file', file_get_contents($data['filePath']), $data['fileName'])
                ->post($url, $data);
        }

        return Http::post($url, $data);
    }
}
