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
namespace WellCommerce\ClientBundle\Entity;

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\CatalogBundle\Entity\ProductAwareTrait;

/**
 * Class Client
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlist implements ClientWishlistInterface
{
    use Timestampable, ClientAwareTrait, ProductAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }
}
