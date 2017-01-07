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

namespace WellCommerce\Bundle\DictionaryBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class DictionaryDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'          => 'dictionary.id',
            'identifier'  => 'dictionary.identifier',
            'translation' => 'dictionary_translation.value',
            'locale'      => 'dictionary_translation.locale',
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('dictionary.id');
        $queryBuilder->leftJoin('dictionary.translations', 'dictionary_translation');
        
        return $queryBuilder;
    }
}
