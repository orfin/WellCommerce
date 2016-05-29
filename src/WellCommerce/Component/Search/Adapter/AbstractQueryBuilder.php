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

namespace WellCommerce\Component\Search\Adapter;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Component\Search\Model\FieldInterface;
use WellCommerce\Component\Search\Request\SearchRequestInterface;

/**
 * Class AbstractQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var SearchRequestInterface
     */
    protected $request;
    
    /**
     * @var int
     */
    protected $termMinimumLength;
    
    /**
     * ElasticSearchQueryBuilder constructor.
     *
     * @param SearchRequestInterface $request
     * @param int                    $termMinimumLength
     */
    public function __construct(SearchRequestInterface $request, int $termMinimumLength)
    {
        $this->request           = $request;
        $this->termMinimumLength = $termMinimumLength;
    }
    
    public function getQuery()
    {
        $fields = $this->getFilteredFields();
        $phrase = $this->getPhrase();
        
        if ($fields->count()) {
            return $this->createMultiFieldSearch($fields);
        }
        
        return $this->createSimpleSearch($phrase);
    }
    
    abstract protected function createMultiFieldSearch(Collection $fields);

    abstract protected function createSimpleSearch(string $phrase);

    protected function getPhrase() : string
    {
        return strlen($this->request->getPhrase()) >= $this->termMinimumLength ? $this->request->getPhrase() : '';
    }

    protected function getFilteredFields() : Collection
    {
        return $this->request->getFields()->filter(function (FieldInterface $field) {
            return strlen($field->getValue()) >= $this->termMinimumLength;
        });
    }
}
