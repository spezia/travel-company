<?php

namespace App\Services;

class CostCompany
{

    private $companyData = [];
    private $travelData = [];
    private $subCompaniesCost = 0;

    /**
     * Show list of nested companies and calcuate cost of travels
     *
     * @return array
     */
    public function getList(): array
    {
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
     * Add children companies
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
                $this->subCompaniesCost = $this->subCompaniesCost + $costByCompany;
                $element['cost'] = $costByCompany;

                $children = $this->buildNestedArraysOfCompanies($elements, $element['id']);
                if ($children) {
                    $element['cost'] = $element['cost'] + end($children)['cost'];
                    $element['children'] = $children;
                } else {
                    $element['children'] = [];
                }

                $result[] = $element;
            }
        }

        return $result;
    }
}
