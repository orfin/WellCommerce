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

namespace WellCommerce\Bundle\UserBundle\Provider;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use WellCommerce\Bundle\CoreBundle\Provider\AbstractResourceProvider;

/**
 * Class UserProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserProvider extends AbstractResourceProvider implements UserProviderInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Constructor
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getResource($strict = true)
    {
        $token = $this->tokenStorage->getToken();
        if (null !== $token) {
            return $token->getUser();
        }

        return null;
    }
}
