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

namespace WellCommerce\Bundle\WishlistBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;

/**
 * Class WishlistRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WishlistRepository extends EntityRepository implements WishlistRepositoryInterface
{
    public function getClientWishlistCollection(ClientInterface $client) : Collection
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->eq('client', $client));
        
        return $this->matching($criteria);
    }
}
