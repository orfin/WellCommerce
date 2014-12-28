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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Fixed;

use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractNode;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;

/**
 * Class AbstractFixedField
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractFixedField extends AbstractNode implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function addElement(ElementInterface $element)
    {
        throw new \BadMethodCallException(
            sprintf('Cannot add element "%s" as it is allowed for containers and fieldsets', get_class($element))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(FilterInterface $filter)
    {
        throw new \BadMethodCallException(
            sprintf('Cannot add filter "%s" as it is allowed for containers and fieldsets', get_class($filter))
        );
    }
}
