<?php

namespace App\Contracts;

/**
 *  Fetch json data
 */
interface JsonDataFromUrl
{

    /**
     * Fetch json from the url
     *
     * @param string $url
     * 
     * @return array
     */
    static public function fetchJsonData(string $url): array;
}
