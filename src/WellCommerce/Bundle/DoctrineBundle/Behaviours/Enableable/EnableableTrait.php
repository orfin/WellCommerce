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

namespace WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable;

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
    public function getEnabled() : bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }
}
