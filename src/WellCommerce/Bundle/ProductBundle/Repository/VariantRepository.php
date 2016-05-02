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
namespace WellCommerce\Bundle\ProductBundle\Repository;

use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Class VariantRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class VariantRepository extends EntityRepository implements VariantRepositoryInterface
{
    public function findVariant(int $id, ProductInterface $product) : VariantInterface
    {
        return $this->findOneBy([
            'product' => $product,
            'id'      => $id
        ]);
    }
}
