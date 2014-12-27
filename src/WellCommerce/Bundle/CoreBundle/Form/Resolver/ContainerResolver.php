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

namespace WellCommerce\Bundle\CoreBundle\Form\Resolver;

/**
 * Class ContainerResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContainerResolver extends AbstractResolver implements ResolverInterface
{
    const SERVICE_TAG_NAME = 'form.container';
    const INTERFACE_CLASS  = 'WellCommerce\\Bundle\\CoreBundle\\Form\\Elements\\Container\\ContainerInterface';
}