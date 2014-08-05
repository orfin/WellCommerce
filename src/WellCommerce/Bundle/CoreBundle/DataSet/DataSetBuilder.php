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

namespace WellCommerce\Bundle\CoreBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\AbstractComponent;
use WellCommerce\Bundle\CoreBundle\Event\DataSetEvent;

/**
 * Class DataSetBuilder
 *
 * @package WellCommerce\Bundle\CoreBundle\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetBuilder extends AbstractComponent
{
    /**
     * Creates the DataSet
     *
     * @param DataSetInterface $dataset
     */
    public function create(DataSetInterface $dataset)
    {
        $dataset->addColumns();

        $eventName = $this->getInitEventName($dataset->getIdentifier());
        $event     = new DataSetEvent($dataset);
        $this->getDispatcher()->dispatch($eventName, $event);

        return $event->getDataSet();
    }

    /**
     * Returns init event name
     *
     * @return string
     */
    private function getInitEventName($identifier)
    {
        return sprintf('%s.%s', $identifier, DataSetInterface::DATASET_INIT_EVENT);
    }
} 