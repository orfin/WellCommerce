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

namespace WellCommerce\Bundle\CoreBundle\Provider;

/**
 * Class ResourceProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ResourceProvider implements ResourceProviderInterface
{
    /**
     * @var object
     */
    protected $currentResource;

    /**
     * {@inheritdoc}
     */
    public function getCurrentResource()
    {
        return $this->currentResource;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentResource($resource)
    {
        $this->currentResource = $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentResource()
    {
        return (null !== $this->currentResource);
    }
}
