<?php

namespace App\Services;

use App\Contracts\DataArray;

/**
 * Company specific functionality
 */
class Company implements DataArray
{
    const URL = 'https://5f27781bf5d27e001612e057.mockapi.io/webprovise/companies';


    static public function getData(): array
    {
        return RemoteApi::fetchJsonData(Company::URL);
    }
}
