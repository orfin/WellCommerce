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

use WellCommerce\Bundle\CoreBundle\Form\Rules\RuleInterface;

/**
 * Class RuleResolver
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Resolver
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RuleResolver extends AbstractResolver implements ResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($type, array $options = [])
    {
        $service = $this->container->get($this->guess($type));

        if (!$service instanceof RuleInterface) {
            throw new \LogicException('Rule must implement RuleInterface');
        }

        $service->setOptions($options);

        return $service;
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceNamePattern()
    {
        return 'form.rule.%s';
    }
} 