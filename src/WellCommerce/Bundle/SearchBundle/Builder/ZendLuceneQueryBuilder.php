<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\SearchBundle\Builder;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\SearchBundle\Query\SearchQuery;

/**
 * Class SearchQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ZendLuceneQueryBuilder implements SearchQueryBuilderInterface
{
    private $queries;

    public function __construct()
    {
        $this->queries = new ArrayCollection();
    }

    public function addMatchQuery(string $fieldName, $value) : SearchQueryBuilderInterface
    {
        $query = new MatchQueryType($fieldName, $value);
        $this->queries->add($query);

        return $this;
    }

    public function addFilterQuery(string $fieldName, $value) : SearchQueryBuilderInterface
    {
        $query = new FilterQueryType($fieldName, $value);
        $this->queries->add($query);

        return $this;
    }

    public function addBoolQuery(string $fieldName, $value) : SearchQueryBuilderInterface
    {
        $query = new BoolQueryType($fieldName, $value);
        $this->queries->add($query);

        return $this;
    }

    public function addFuzzyQuery(string $fieldName, $value) : SearchQueryBuilderInterface
    {
        $query = new FuzzyQueryType($fieldName, $value);
        $this->queries->add($query);

        return $this;
    }
    
    public function getQuery() : SearchQuery
    {
        return $this->queries;
    }
}
