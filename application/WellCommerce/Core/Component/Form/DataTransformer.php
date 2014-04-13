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

namespace WellCommerce\Core\Component\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AbstractDataTransformer
 *
 * @package WellCommerce\Core\Component\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataTransformer
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
} 