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

namespace WellCommerce\Component\Search\Adapter\ZendLucene;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Component\Search\Adapter\AbstractQueryBuilder;
use ZendSearch\Lucene\Index\Term as IndexTerm;
use ZendSearch\Lucene\Search\Query\Wildcard;

/**
 * Class ZendLuceneQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ZendLuceneQueryBuilder extends AbstractQueryBuilder
{
    protected function createMultiFieldSearch(Collection $fields)
    {
        return $this->getPhrase();
    }

    protected function createSimpleSearch(string $phrase)
    {
        $term  = new IndexTerm($phrase);
        $query = new Wildcard($term);

        return $query;
    }
}
