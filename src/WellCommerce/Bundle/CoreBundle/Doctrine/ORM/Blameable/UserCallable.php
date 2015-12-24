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

namespace WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Blameable;

use Symfony\Component\DependencyInjection\Container;

/**
 * Class UserCallable
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserCallable
{
    /**
     * @var Container
     */
    private $container;

    /**
     * UserCallable constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke()
    {
        $token = $this->container->get('security.token_storage')->getToken();
        if (null !== $token) {
            return $token->getUser();
        }
    }
}
