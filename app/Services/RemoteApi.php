<?php

namespace App\Services;

use App\Contracts\JsonDataFromUrl;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

/**
 * Fetch data from remote API endpoint
 */
class RemoteApi implements JsonDataFromUrl
{
    static public function fetchJsonData(string $url): array
    {
        try {

            return json_decode(file_get_contents($url), true);
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            throw new RuntimeException('Something is wrong.');
        }
    }
}
