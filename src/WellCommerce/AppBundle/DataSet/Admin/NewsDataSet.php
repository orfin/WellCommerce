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

namespace WellCommerce\AppBundle\DataSet\Admin;

use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\CoreBundle\DataSet\AbstractDataSet;

/**
 * Class NewsDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'   => 'news.id',
            'name' => 'news_translation.topic',
        ]);
    }
}
