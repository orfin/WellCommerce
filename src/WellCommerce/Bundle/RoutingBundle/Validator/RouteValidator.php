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

namespace WellCommerce\Bundle\RoutingBundle\Validator;

use Doctrine\Common\Util\Debug;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableSubjectInterface;

/**
 * Class RouteValidator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteValidator
{
    public static function validate(RoutableSubjectInterface $object, ExecutionContextInterface $context)
    {
        Debug::dump($object->getRoute()->getIdentifier());
        Debug::dump($object);
        Debug::dump($context);
        die();
    }
}
