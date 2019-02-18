<?php
namespace Lib\Editors\Fields;


use Lib\Exception;
use Phalcon\Validation\ValidatorInterface;

trait TFieldFilters
{
    /** @var ValidatorInterface[] */
    protected $filters = [];

    /**
     *
     * Returns the field filters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Adds a filter to current list of filters
     * @param string $filter
     * @return $this
     */
    public function addFilter($filter)
    {
        $filters = $this->filters;

        if(is_array($filters))
        {
            $this->filters[] = $filter;
        }
        else
        {
            if(is_string($filters))
            {
                $this->filters = [$filters, $filter];
            }
            else
            {
                $this->filters = [$filter];
            }
        }

        return $this;
    }

    /**
     * Sets the field filters
     * @param array $filters
     * @return TFieldFilters
     * @throws Exception
     */
    public function setFilters(array $filters)
    {
        if(!is_string($filters) && !is_array($filters))
        {
            throw new Exception('Wrong filter type added');
        }

        $this->filters = $filters;

        return $this;
    }

}