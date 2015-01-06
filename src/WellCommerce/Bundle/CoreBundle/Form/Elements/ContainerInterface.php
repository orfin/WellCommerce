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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

/**
 * Class ContainerInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface ContainerInterface
{
    public function addChild(ElementInterface $element);

    public function addFilters(array $filters = []);

    public function addRules(array $rules = []);

    public function addDependencies(array $dependencies = []);
} 