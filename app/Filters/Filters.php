<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request, $builder;

    protected $filters = [];

    /**
     * ThreadsFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    /**
     * @param $builer
     */
    public function apply($builer)
    {
        // we apply our filter to builder

        $this->builder = $builer;


        foreach ($this->getFilter() as $filter => $value)
        {
            if(method_exists($this, $filter))
            {
                $this->$filter($value);

            }
        }
        return $builer;
    }

    /**
     * @return array
     */
    protected function getFilter(): array
    {
        return $this->request->only($this->filters);
    }
}