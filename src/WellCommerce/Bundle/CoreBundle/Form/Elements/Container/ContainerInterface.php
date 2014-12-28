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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Container;

use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;

/**
 * Class ContainerInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface ContainerInterface
{
    /**
     * Returns container name
     *
     * @return string
     */
    public function getName();

    /**
     * Adds element to collection and returns it
     *
     * @param ElementInterface $element
     *
     * @return ElementInterface
     */
    public function addElement(ElementInterface $element);

    /**
     * Adds filter to all container elements
     *
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter);
} 