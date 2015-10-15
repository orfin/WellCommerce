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

namespace WellCommerce\Bundle\ClientBundle\Provider;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Provider\AbstractResourceProvider;
use WellCommerce\Bundle\ProductBundle\Provider\ClientProviderInterface;

/**
 * Class ProductProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientProvider extends AbstractResourceProvider implements ClientProviderInterface
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
        $client = $this->getUser();

        if ($client instanceof ClientInterface) {
            return $client;
        }

        return null;
    }

    protected function getUser()
    {
        $token = $this->tokenStorage->getToken();
        if (null !== $token) {
            return $token->getUser();
        }

        return null;
    }
}
