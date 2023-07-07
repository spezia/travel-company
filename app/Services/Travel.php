<?php

namespace App\Services;

use App\Contracts\DataArray;

/**
 * Travel specific functionality
 */
class Travel implements DataArray
{
    const URL = 'https://5f27781bf5d27e001612e057.mockapi.io/webprovise/travels';

    static public function getData(): array
    {
        return RemoteApi::fetchJsonData(Travel::URL);
    }
}
