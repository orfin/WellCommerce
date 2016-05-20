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

namespace WellCommerce\Bundle\CoreBundle\Security;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class FirewallManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class FirewallManager
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestMatcher[]
     */
    private $map;

    /**
     * FirewallManager constructor.
     *
     * @param \Symfony\Component\HttpFoundation\RequestMatcher[] $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @param Request $request
     *
     * @return int|null|string
     */
    public function getFirewallNameForRequest(Request $request)
    {
        foreach ($this->map as $firewallName => $requestMatcher) {
            if (null === $requestMatcher || $requestMatcher->matches($request)) {
                return $firewallName;
            }
        }

        return null;
    }
}
