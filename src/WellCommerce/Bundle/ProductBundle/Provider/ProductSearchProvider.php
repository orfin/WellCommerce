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

namespace WellCommerce\Bundle\ProductBundle\Provider;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\In;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;

/**
 * Class ProductProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductSearchProvider extends AbstractContainerAware implements ProductSearchProviderInterface
{
    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * ProductSearchProvider constructor.
     *
     * @param DataSetInterface $dataset
     */
    public function __construct(DataSetInterface $dataset)
    {
        $this->dataset = $dataset;
    }

    /**
     * {@inheritdoc}
     */
    public function addSearchConditions(ConditionsCollection $conditions)
    {
        $requestHelper = $this->getRequestHelper();
        $phrase        = $requestHelper->getAttributesBagParam('phrase');
        $conditions    = $this->addSearchPhraseConditions($conditions, $phrase);

        return $conditions;
    }

    /**
     * Adds additional search conditions
     *
     * @return ConditionsCollection
     */
    protected function addSearchPhraseConditions(ConditionsCollection $conditions, $phrase)
    {
        $identifiers = $this->getProductIds($phrase);
        $conditions->add(new In('id', $identifiers));

        return $conditions;
    }

    protected function getProductIds($phrase)
    {
        /** @var $queryBuilder \Doctrine\ORM\QueryBuilder */
        $queryBuilder = $this->get('product.repository')->createQueryBuilder($this->get('product.repository')->getAlias());
        $queryBuilder->select('product.id');
        $queryBuilder->leftJoin('product.translations', 'product_translation');
        $queryBuilder->andWhere($queryBuilder->expr()->like('product_translation.name', ':phrase'));
        $queryBuilder->orWhere($queryBuilder->expr()->like('product_translation.description', ':phrase'));
        $queryBuilder->setParameter('phrase', '%' . $phrase . '%');
        $query   = $queryBuilder->getQuery();
        $results = $query->getArrayResult();

        $identifiers = [];
        foreach ($results as $result) {
            $identifiers[] = $result['id'];
        }

        return $identifiers;
    }
}
