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

namespace WellCommerce\AppBundle\Collection;

use WellCommerce\AppBundle\Entity\LayoutBox;
use WellCommerce\AppBundle\Repository\LayoutBoxRepositoryInterface;
use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class LayoutBoxCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxCollection extends ArrayCollection
{
    /**
     * Constructor
     *
     * @param LayoutBoxRepositoryInterface $layoutBoxRepository
     */
    public function __construct(LayoutBoxRepositoryInterface $layoutBoxRepository)
    {
        $layoutBoxes = $layoutBoxRepository->findAll();
        foreach ($layoutBoxes as $layoutBox) {
            $this->add($layoutBox);
        }
    }

    public function add(LayoutBox $box)
    {
        $this->items[$box->getIdentifier()] = $box;
    }
}
