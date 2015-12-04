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

namespace WellCommerce\Bundle\AppBundle\Doctrine\ORM\Behaviours;

/**
 * Class EnableableTrait
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
trait EnableableTrait
{
    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool)$enabled;
    }
}
