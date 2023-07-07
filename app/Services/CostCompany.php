<?php

namespace App\Services;

class CostCompany
{

    private $companyData = [];
    private $travelData = [];
    private $subCompaniesCost = 0;
    private $childrenCompaniesCost = 0;

    public function getList(): array
    {
        // $start = microtime(true);
        $this->travelData = Travel::getData();
        $this->companyData = Company::getData();
        $data = [];

        foreach ($this->companyData as $item) {
            $childrenCompanies = [];
            $this->subCompaniesCost = 0;
            $childrenCompanies = $this->buildNestedArraysOfCompanies($this->companyData, $item['id']);

            $data[] = [
                'id' => $item['id'],
                'createdAt' => $item['createdAt'],
                'name' => $item['name'],
                'parentId' => $item['parentId'],
                'cost' =>  CostCompany::calculateTravelCostByCompany($item['id']) + $this->subCompaniesCost,
                'children' => $childrenCompanies,
            ];
        }

        // dd('Total time: ' .  (microtime(true) - $start));
        return $data;
    }

    /**
     * Calculate travel cost for given company
     *
     * @param string $companyId
     * 
     * @return float
     */
    private function calculateTravelCostByCompany(string $companyId): float
    {
        return collect($this->travelData)->where('companyId', $companyId)->sum('price');
    }

    /**
     * Make children companies
     *
     * @param array $elements
     * @param integer $parentId
     * 
     * @return array
     */
    private function buildNestedArraysOfCompanies(array $elements, $parentId = 0): array
    {
        $result = [];

        foreach ($elements as $element) {

            if ($element['parentId'] == $parentId) {
                $costByCompany = CostCompany::calculateTravelCostByCompany($element['id']);

                $this->childrenCompaniesCost = $costByCompany + $this->childrenCompaniesCost;
                $this->subCompaniesCost = $this->subCompaniesCost + $costByCompany;

                $children = $this->buildNestedArraysOfCompanies($elements, $element['id']);
                if ($children) {
                    $element['cost'] = $costByCompany + $this->childrenCompaniesCost;
                    $element['children'] = $children;
                } else {
                    $element['cost'] = $costByCompany;
                    $element['children'] = [];
                    $this->childrenCompaniesCost = $costByCompany;
                }

                $result[] = $element;
            }
        }

        return $result;
    }
}
