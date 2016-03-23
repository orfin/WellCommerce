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

namespace WellCommerce\Component\Form\Resolver;

use WellCommerce\Component\Form\Dependencies\DependencyInterface;

/**
 * Class DependencyResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DependencyResolver extends AbstractResolver
{
    const SERVICE_TAG_NAME = 'form.dependency';
    const INTERFACE_CLASS  = DependencyInterface::class;
}
