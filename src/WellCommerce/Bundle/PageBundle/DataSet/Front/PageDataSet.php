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

namespace WellCommerce\Bundle\PageBundle\DataSet\Front;

use WellCommerce\Bundle\PageBundle\DataSet\Admin\PageDataSet as BaseDataSet;
use WellCommerce\Bundle\PageBundle\Entity\Page;
use WellCommerce\Bundle\PageBundle\Entity\PageTranslation;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class PageDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataSet extends BaseDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        parent::configureOptions($configurator);
        
        $configurator->setColumnTransformers([
            'route' => $this->getDataSetTransformer('route')
        ]);
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Page::class,
            PageTranslation::class
        ]));
    }
    
    protected function getDataSetRequest(array $requestOptions = []) : DataSetRequestInterface
    {
        $request = parent::getDataSetRequest($requestOptions);

        $request->addCondition(new Eq('publish', true));

        return $request;
    }
}
